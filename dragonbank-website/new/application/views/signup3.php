<div class="content-body">

	<div class="singup-container">
	
		<img src="<?=ASS_IMG_PATH?>singup3.png" alt="profile setup 3" class="singup-title" />
		
		<div class="pull-right attached-right">
		
			<div class="btn-group btn-steps">
				<button type="button" class="btn btn-step btn-step-title">Setup progress</button>
				<button type="button" class="btn btn-step btn-step-active">step 1</button>
				<button type="button" class="btn btn-step btn-step-active">step 2</button>
				<button type="button" class="btn btn-step btn-step-active">step 3</button>
				<button type="button" class="btn btn-step">done</button>
			</div>
			
		</div>
		
	</div><!-- .singup-container -->

	<div class="singup-container">
		
		<div class="singup-box text-right">
		
			<form class="form-horizontal order-form singup-form-3" role="form" id="signup3-edit" method="POST">
			
			<div class="table-responsive">
			
			<table class="table table-condensed table-dragon">
		        <thead>
		          <tr>
		            <th>den allocation</th>
		            <th>Spend</th>
		            <th>Save</th>
		            <th>Give</th>
		          </tr>
		        </thead>
		        <tbody>
		          <tr>
		            <td class="table-input"><label><input type="radio" name="allocation" id="den1" value=1 checked="checked" onclick="getAllocation();"> Default</label></td>
		            <td><input type="hidden" name="spend1" value=80.00>80%</td>
		            <td><input type="hidden" name="save1" value=10.00>10%</td>
		            <td><input type="hidden" name="give1" value=10.00>10%</td>
		          </tr>
		          <tr>
		            <td class="table-input"><label><input type="radio" name="allocation" id="den2" value=2> The Dragon Saver </label></td>
		            <td><input type="hidden" name="spend2" value=40.00>40%</td>
		            <td><input type="hidden" name="save2" value=50.00>50%</td>
		            <td><input type="hidden" name="give2" value=10.00>10%</td>
		          </tr>
		          <tr>
		            <td class="table-input"><label><input type="radio" name="allocation" id="den3" value=3> Across the Dens </label></td>
					  <td><input type="hidden" name="spend3" value=33.40>33.4%</td>
					  <td><input type="hidden" name="save3" value=33.30>33.3%</td>
					  <td><input type="hidden" name="give3" value=33.30>33.3%</td>
		          </tr>
		          <tr>
		            <td class="table-input"><label><input type="radio" name="allocation" id="den4" value=4> Custom</label></td>
		            <td><input type="text" class="form-control den-form custom" id="spend" name="spend4" value=0></td>
		            <td><input type="text" class="form-control den-form custom" id="save" name="save4" value=0></td>
		            <td><input type="text" class="form-control den-form custom" id="give" name="give4" value=0></td>
		          </tr>
		          <tr>
		            <td class="td-white"></td>
		            <td class="td-white"></td>
		            <td class="td-white"></td>
		            <td class="td-white"></td>
		          </tr>
				  <?php if( isset( $init_deposit ) ): ?>
		          <tr>
		            <td class="td-white">Current Dens Balance</td>
		            <td class="td-white init_deposit"></td>
		            <td class="td-white init_deposit"></td>
		            <td class="td-white init_deposit"></td>
		          </tr>
				  <input type="hidden" name="init_deposit" id="init_deposit" value="<?= $init_deposit; ?>" >
				  <?php endif; ?>
				  <tr>
					<td class="td-white"><label class="red"><?php echo $this->session->flashdata("flash"); ?></label></td>
				  </tr>
		        </tbody>
		    </table>
			</div>
			
			<button type="submit" id="submit" class="btn btn-order btn-order-xs"> I'm done! <div class="glare"></div> </button>
			
			</form>
			
		</div><!-- .singup-box -->
		
	</div><!-- .singup-container -->

</div>