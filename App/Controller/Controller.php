<?php
namespace App\Controller;

use App\Core\AbstractController;

class Controller extends AbstractController
{
    public function actionIndex()
    {
        $params = [];

        try {
            $bodyParams = $this->getRequestParams();
            $this->validate($bodyParams);

            if (isset($bodyParams['dates'])) {
                $analytics = $this->prepareAnalyticsData($bodyParams['dates']);
                $params['result'] = $analytics['result'];

                $this->model->insertAnalytics($analytics);
            }
        } catch (\Exception $e) {
            if ($this->isAjax()) {
                $params['error'] = $e->getMessage();
            } else {
                throw $e;
            }
        }

        if ($this->isAjax()) {
            return json_encode($params);
        }

        return $this->render('date/form.php', $params);
    }

    private function validate($bodyParams)
    {
        if (isset($bodyParams['dates']) && !preg_match("/^[0-9]{4}\/[0-1][0-9]\/[0-3][0-9]\s?-\s?[0-1][0-9].[0-3][0-9].[0-9]{4}$/", $bodyParams['dates'])) {
            throw new \Exception('Parameter `dates` is not match to necessary format `yyyy/mm/dd - mm.dd.yyyy`!');
        }

        return true;
    }

    private function prepareAnalyticsData($dates)
    {
        $analytics = [];
        $dates = explode('-', $dates);
        $leftDate = trim($dates[0]);
        $rightDate = trim($dates[1]);

        $leftOperand = \DateTime::createFromFormat('Y/m/d', $leftDate);
        $rightOperand = \DateTime::createFromFormat('m.d.Y', $rightDate);

        if  (!$leftOperand instanceof \DateTime) {
            throw new \Exception(sprintf('Unable to convert %s string to DateTime!', $leftDate));
        }

        if  (!$rightOperand instanceof \DateTime) {
            throw new \Exception(sprintf('Unable to convert %s string to DateTime!', $rightDate));
        }

        $interval = $leftOperand->diff($rightOperand);
        $analytics['leftOperand'] = $leftOperand;
        $analytics['rightOperand'] = $rightOperand;
        $analytics['result'] = $interval->d;
        $analytics['ip'] = $this->getClientIp();

        return $analytics;
    }
}