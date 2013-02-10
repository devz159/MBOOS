<select class="month" name="month">
				<option value="-1">Week:</option>
					<?php $upper = 1; $lower = 52;  ?>
					<?php for($i = $upper; $i <= $lower; $i++): ?>
				<option value="<?php echo $i;?>" ><?php echo $i; ?> week</option>
					<?php endfor; ?>
		</select>
		
		<select class="select span7" name="week">
                <?php for ($i=1;$i<60;$i++){?>
                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                <?php }?>
                </select>
                
                <select class="hr_month" name="month">
			<option value="-1">Month:</option>
			<?php $upper = 12; $lower = 1;  ?>
			<?php for($i = $upper; $i >= $lower; $i--): ?>
			<option value="<?php echo $i;?>" ><?php echo $i; ?></option>
			<?php endfor; ?>
		</select>
		
		
				<select class="hr_year" name="year">
		
			<option value="-1">Year:</option>
			<?php $upper = 2030; $lower = 2013;  ?>
			<?php for($i = $upper; $i >= $lower; $i--): ?>
			<option value="<?php echo $i;?>" ><?php echo $i; ?></option>
			<?php endfor; ?>
		
		</select>