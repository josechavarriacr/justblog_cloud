<?php
use yii\helpers\Url;
Yii::$app->site->getMetaTags();

?>

<div class="site-index">

	<div class="jumbotron">
		<h1>Just Blog</h1>
		<p class="lead">
			<span class="label label-info">Easy</span>
			<span class="label label-success">Pretty</span>
			<span class="label label-primary">Light</span>
			<span class="label label-danger">Modern</span>
		</p>
	</div>

	<div class="body-content">
		<div class="col-md-9"><!-- col-md-9 start -->
			<hr>
			<div class="blog row">
				<div class="col-lg-9 col-lg-offset-3">
					<h2 class="heading">Accees</h2>
					<p>The defalut site for visitor o readers</p><p><a href="" style="font-size: 16px" class="badge progress-bar-info">Frontend</a></p>
					<p>This part contains all the logic and processes of a platform Blogging/CMS</p><p><a href="admin" style="font-size: 16px" class="badge progress-bar-warning">Backend</a></p>
				</div> 
			</div>
		</div>

		<!-- start _posts -->
		<?php echo $this->render('_posts', [
			'model' => $model,
			]); ?>
			<!-- end _posts -->

		</div>
	</div>
