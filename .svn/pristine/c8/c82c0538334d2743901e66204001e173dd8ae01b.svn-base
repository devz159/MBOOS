<p>Answer</p>  
<?php  echo validation_errors();  ?>
<form method="POST" action="<?php echo base_url(); ?>admin/login/secret_question_validate">

<?php foreach($my_question as $rec):?>		    		

<p><label><?php echo $rec->mboos_user_secret_question; ?>: </label><input type="text" name="secret_answer" /></p>
<input type="hidden" name="email" value="<?php echo $_POST['email']; ?>" />
<p><input type="submit" value="submit"></p>

<?php endforeach;?>

</form>