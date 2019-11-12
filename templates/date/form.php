<form id="dates-form" action="/" method="POST">
    <div class="form-content">
        <textarea name="dates" id="dates" cols="100" rows="1"></textarea>
        <div class="btn-group">
            <input class="btn" id="post" type="submit"  value="POST">
            <button class="btn" id="ajax" >AJAX</button>
        </div>
    </div>
    <div class="form-result">% <span class="message"><?php echo isset($days) ? $days : ''; ?></span>  %</div>
</form>
