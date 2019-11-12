<?php
namespace App\Controller;

use App\Core\AbstractController;

class Controller extends AbstractController
{
    public function actionIndex()
    {
        $params = [];

        if ($body = $this->getRequestBody()) {
            $bodyParams = $this->parseJson($body, true);

            if ($this->validate($bodyParams)) {
                $analytics = $this->prepareAnalytics($bodyParams['dates']);
                $params['days'] = $analytics['days'];
            } else {
                $params['errors'] = $this->getErrors();
            }
        }

        if ($this->isAjax()) {
            return json_encode($params);
        }

        return $this->render('date/form.php', $params);
    }

    private function validate($bodyParams)
    {
        if (!isset($bodyParams['dates'])) {
            $this->addError('Required parameter `dates` is miss!');
        } elseif (!preg_match("/^[0-9]{4}\/[0-1][0-9]\/[0-3][0-9]\s?-\s?[0-1][0-9].[0-3][0-9].[0-9]{4}$/", $bodyParams['dates'])) {
            $this->addError('Parameter `dates` is not match to necessary format `yyyy/mm/dd - mm.dd.yyyy`!');
        }

        return count($this->getErrors()) === 0;
    }

    private function prepareAnalytics($dates)
    {
        $analytics = [];
        $dates = explode('-', $dates);
        $leftDate = trim($dates[0]);
        $rightDate = trim($dates[1]);

        $analytics['leftOperand'] = \DateTime::createFromFormat('Y/m/d', $leftDate);
        $analytics['rightOperand'] = \DateTime::createFromFormat('m.d.Y', $rightDate);

        $interval = $analytics['leftOperand']->diff($analytics['rightOperand']);
        $analytics['days'] = $interval->d;

        return $analytics;
    }
}