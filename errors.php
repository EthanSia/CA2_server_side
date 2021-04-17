<style>
.error 
{
	color: #FF0000;
	font-size:20px;
}

</style>

<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p class="error">*<?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>