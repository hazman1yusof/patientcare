
<div class="ui segments" style="position: relative;">
	<div class="ui secondary segment bluecloudsegment">
		<div class="ui labeled small input">
			<div class="ui blue label">Date</div>
			<input type="date" readonly value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
		</div>
		<select class="ui small dropdown">
		  <option value="">Dialysis recorded before</option>
		</select>

		<a class="ui orange disabled label" id="stats_diet" style="display: none;"></a>
		<div class="ui small blue icon buttons" id="btn_grp_dialysis" style="position: absolute;
					padding: 0 0 0 0;
					right: 40px;
					top: 9px;
					z-index: 2;">
		  <button class="ui button" id="new_dialysis"><span class="fa fa-plus-square-o"></span> New</button>
		  <button class="ui button" id="edit_dialysis"><span class="fa fa-edit fa-lg"></span> Edit</button>
		  <button class="ui button" id="save_dialysis"><span class="fa fa-save fa-lg"></span> Save</button>
		  <button class="ui button" id="cancel_dialysis"><span class="fa fa-ban fa-lg"></span> Cancel</button>
		</div>
	</div>


	<div class="ui segment diaform">
		<!-- <div class="ui message">
		<div class="ui mini form">
		  <div class="three fields">
		    <div class="field">
					<label><div class="label_hd">Start Date:</div></label>
		      <input type="date" id="seldate" disabled="" value="{{Carbon\Carbon::now()}}">
		    </div>
		    <div class="field"><label><div class="label_hd">&nbsp;</div></label>
		      <button type="button" class="ui mini blue submit button" id="addnew_dia" disabled="">Add New Record</button>
		      <button type="button" class="ui mini blue submit button" id="edit_dia" disabled="">Edit Record</button>
		    </div>
		  </div>
		</div>
		</div> -->

		<input type="hidden" name="episno" id="episno">
		<input type="hidden" name="mrn" id="mrn">
		<form id="daily_form" class="ui mini form" autocomplete="off">
			<div class="four fields">
				<div class="field">
					<div class="clinic_code">
						<label><div class="label_hd">START TIME:</div></label>
						<input type="time" name="start_time" id="start_time" class="required" value="">
					</div>
				</div>
				<div class="field">
					<div class="clinic_code">
						<label><div class="label_hd">PREV POST WEIGHT:</div></label>
						<input type="text" name="prehd_weight" id="prehd_weight"  value="" >
					</div>
				</div>
				<div class="field">
					<div class="clinic_code">
						<label> MACHINE NO:</label>
						<input type="text" name="hep_loading" id="hep_loading" class="required" value=""  >
					</div>
				</div>
				<div class="field">
					<label> DIALYSATE CA:</label>
					<select class="ui selection dropdown">
					  <option value="">Select Here</option>
					  <option value="1">1</option>
					  <option value="1.25">1.25</option>
					  <option value="1.5">1.5</option>
					</select>
				</div>
			</div>
			
			<div class="four fields">
				<div class="field">
					<div class="clinic_code">
						<label><div class="label_hd">TIME COMPLETE:</div></label>
						<input type="time" name="end_time" class="w" id="end_time"   value="">
					</div>
				</div>
				<div class="field">
					<div class="clinic_code">
					    			<label><div class="label_hd">PRE WEIGHT:</div></label>
						<input type="text" name="prev_post_weight" id="prev_post_weight"  value="" >
					</div>
				</div>
				 <div class="field">
					<label> HEPARIN TYPE:</label>
					<select class="ui selection dropdown">
					  <option value="">Select Here</option>
					  <option value="NORMAL">NORMAL</option>
					  <option value="TIGHT">TIGHT</option>
					  <option value="FREE">FREE</option>
					</select>
				</div>

				 <div class="field">
					<label> DIALYSATE FLOW:</label>
					<select class="ui selection dropdown">
					  <option value="">Select Here</option>
					  <option value="300">300</option>
					  <option value="500">500</option>
					  <option value="800">800</option>
					</select>
				</div>
			</div>

			<div class="four fields">
				<div class="field">
					<div class="clinic_code">
						<label><div class="label_hd">DURATION OF HD:</div></label>
						<input type="text" class="w" name="duration" id="duration"  value="" >
					</div>
				</div>
			    <div class="field">
					<div class="clinic_code">
						<label><div class="label_hd">IDWG:</div></label>
						<input type="text" name="dialytic_weight" id="dialytic_weight"  value="" >
					</div>
				</div>
				<div class="field">
					<div class="clinic_code">
						<label> HEPARIN BOLUS:</label>
						<input type="text" name="tinzaparin" id="tinzaparin" value=""  >
					</div>
				</div>
				<div class="field">
					<div class="clinic_code">
						<label> CONDUCTIVITY:</label>
						<input type="text" name="tinzaparin" id="tinzaparin" value=""  >
					</div>
				</div>
			</div>

			<div class="four fields">
				<div class="field">
					<div class="clinic_code">
						<label><div class="label_hd">LAST VISIT:</div></label>
						<input type="text" class="w" name="duration" id="duration"  value="" >
					</div>
				</div>
			    <div class="field">
					<div class="clinic_code">
						<label><div class="label_hd">TARGET WEIGHT:</div></label>
						<input type="text" name="dialytic_weight" id="dialytic_weight"  value="" >
					</div>
				</div>
				<div class="field">
					<div class="clinic_code">
						<label> HEPARIN MAINTAINANCE:</label>
						<input type="text" name="tinzaparin" id="tinzaparin" value=""  >
					</div>
				</div>
				<div class="field">
					<div class="clinic_code">
						<label> CHECK FOR RESIDUAL:</label>
						<input type="text" name="tinzaparin" id="tinzaparin" value=""  >
					</div>
				</div>
			</div>

			<div class="four fields">
				<div class="field">
					<div class="clinic_code">
						<label><div class="label_hd">DRY WEIGHT:</div></label>
						<input type="text" class="w" name="duration" id="duration"  value="" >
					</div>
				</div>
			    <div class="field">
					<div class="clinic_code">
						<label><div class="label_hd">TARGET UF:</div></label>
						<input type="text" name="dialytic_weight" id="dialytic_weight"  value="" >
					</div>
				</div>
				<div class="field">
					<div class="clinic_code">
						<label> PRIME BY:</label>
						<input type="text" name="tinzaparin" id="tinzaparin" value=""  >
					</div>
				</div>
				<div class="field">
					<div class="clinic_code">
						<label> INITIATED BY:</label>
						<input type="text" name="tinzaparin" id="tinzaparin" value=""  >
					</div>
				</div>
			</div>
		    
		    <hr>

			<h4 class="ui dividing header">PRE HD ASSESSMENT</h4>

			<div class="two fields">

		  	<div class="field">
		  		<div class="clinic_code">
		  			<label style="">BLOOD PRESSURE:</label>
		  				<div class="two fields">
		  					<div class="ui labeled input" style="padding-right:5px">
		  						<div class="ui label">Systolic</div>
		  						<input type="text" name="prehd_exit_site" id="prehd_exit_site" value="" >
		  					</div>
		  					<div class="ui labeled input">
		  						<div class="ui label">Diastolic</div>
		  						<input type="text" name="prehd_exit_site" id="prehd_exit_site" value="" >
		  					</div>
		  				</div>
		  		</div>
		  	</div>
		      
		    <div class="field">
					<div class="clinic_code">
						<label style="">T.P.R:</label>
						<input type="text" name="prehd_exit_site" id="prehd_exit_site" value="" >
					</div>
				</div>
			</div>

			<div class="four fields">

		    <div class="field">
		  			<label >EYE:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="PERIOBITAL EDEMA">PERIOBITAL EDEMA</option>
						  <option value="REDNESS">REDNESS</option>
						  <option value="N/A">N/A</option>
						</select>
		  	</div>

		    <div class="field">
						<label> NECK:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="JUGULAR VENOUS DISTENSION">JUGULAR VENOUS DISTENSION</option>
						  <option value="N/A">N/A</option>
						</select>
		    </div>

		    <div class="field">
						<label> ABDOMEN:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="DISTENDED">DISTENDED</option>
						  <option value="SOFT & NON-TENDER">SOFT & NON-TENDER</option>
						</select>
		    </div>

		    <div class="field">
						<label> SKIN:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="DRY">DRY</option>
						  <option value="RASHES">RASHES</option>
						  <option value="PRURITIS">PRURITIS</option>
						  <option value="N/A">N/A</option>
						</select>
		    </div>
			</div>

			<div class="four fields">

		    <div class="field">
						<label> LOWER LIMB:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="OEDEMATOUS">OEDEMATOUS</option>
						  <option value="ULCER">ULCER</option>
						  <option value="CALLUSES">CALLUSES</option>
						  <option value="BLISTER">BLISTER</option>
						</select>
		    </div>

		    <div class="field">
						<label> ACCESS:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="PERMANENT">PERMANENT</option>
						  <option value="TEMPORARY">TEMPORARY</option>
						</select>
		    </div>

		    <div class="field">
						<label> TYPE:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="RIGHT IJC">RIGHT IJC</option>
						  <option value="LEFT IJC">LEFT IJC</option>
						  <option value="RIGHT SVC">RIGHT SVC</option>
						  <option value="LEFT SVC">LEFT SVC</option>
						  <option value="AVF">AVF</option>
						  <option value="BCF">BCF</option>
						  <option value="GRAFT">GRAFT</option>
						  <option value="RIGHT PERMANENT CATHETER">RIGHT PERMANENT CATHETER</option>
						  <option value="LEFT PERMANENT CATHETER">LEFT PERMANENT CATHETER</option>
						  <option value="RIGHT FEMORAL PERMANENT CATHETER">RIGHT FEMORAL PERMANENT CATHETER</option>
						  <option value="LEFT FEMORAL PERMANENT CATHETER">LEFT FEMORAL PERMANENT CATHETER</option>
						</select>
		    </div>

		    <div class="field">
						<label> BRUIT:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="YES">YES</option>
						  <option value="NO">NO</option>
						</select>
		    </div>
			</div>

			<div class="four fields">
		    <div class="field">
						<label> THRILL:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="YES">YES</option>
						  <option value="NO">NO</option>
						</select>
		    </div>

		    <div class="field">
						<label> DRESSING:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="INTACT">INTACT</option>
						  <option value="WET">WET</option>
						  <option value="LOOSE">LOOSE</option>
						</select>
		    </div>

		    <div class="field">
						<label> RESPIRATORY:</label>
						<select class="ui selection dropdown">
						  <option value="">Select Here</option>
						  <option value="EUPNEA">EUPNEA</option>
						  <option value="BRADYPNEA">BRADYPNEA</option>
						  <option value="TACHYPNEA">TACHYPNEA</option>
						  <option value="HYPERPNEA">HYPERPNEA</option>
						</select>
		    </div>

		    <div class="field">
					<div class="clinic_code">
						<label> CONDITION AVF/EXIT SITE:</label>
						<input type="text" name="tinzaparin" id="tinzaparin" value=""  >
					</div>
		    </div>
			</div>
		    
			<div class="field">
				<div class="clinic_code">
		       <label style="">General Assesment:</label>
					<textarea name="remarks" rows="3" cols="100" ></textarea>
				</div>
			</div>

			<hr>

			<h4 class="ui dividing header">HOURLY CHART</h4>

			<table class="table ui form" id="preHDListMeasure">
				<thead>
					<tr>
						<th style="text-align: right;"></th>
						<th style="text-align: center;">BP</th>
						<th style="text-align: center;">PULSE</th>
						<th style="text-align: center;">DELIVERED HEPARIN</th>
						<th style="text-align: center;">BLOOD FLOW RATE</th>
						<th style="text-align: center;">VENOUS PRESSURE</th>
						<th style="text-align: center;">TMP</th>
						<th style="text-align: center;">UF VOLUME</th>
						<th style="text-align: center;">FLUIDS</th>
					</tr>
				</thead>


				<tbody>
					<tr style="background-color:#f3ffff;">
						<td class="labeltd">1st Hour:</td>
						<td><input type="text" name="" id="" value="" placeholder="BP"></td>
						<td><input type="text" name="" id="" value="" placeholder="PULSE"></td>
						<td><input type="text" name="" id="" value="" placeholder="DELIVERED HEPARIN"></td>
						<td><input type="text" name="" id="" value="" placeholder="BLOOD FLOW RATE"></td>
						<td><input type="text" name="" id="" value="" placeholder="VENOUS PRESSURE"></td>
						<td><input type="text" name="" id="" value="" placeholder="TMP"></td>
						<td><input type="text" name="" id="" value="" placeholder="UF VOLUME"></td>
						<td><input type="text" name="" id="" value="" placeholder="FLUIDS"></td>
					</tr>
					<tr style="background-color:#f3ffff;">
						<td class="labeltd">Complications:</td>
						<td colspan="8"><textarea name="remarks" rows="3" cols="100" style="background-color: #dcf7f7;"></textarea></td>
					</tr>
					<tr style="background-color:#e4ffe4;">
						<td class="labeltd">2nd Hour:</td>
						<td><input type="text" name="" id="" value="" placeholder="BP"></td>
						<td><input type="text" name="" id="" value="" placeholder="PULSE"></td>
						<td><input type="text" name="" id="" value="" placeholder="DELIVERED HEPARIN"></td>
						<td><input type="text" name="" id="" value="" placeholder="BLOOD FLOW RATE"></td>
						<td><input type="text" name="" id="" value="" placeholder="VENOUS PRESSURE"></td>
						<td><input type="text" name="" id="" value="" placeholder="TMP"></td>
						<td><input type="text" name="" id="" value="" placeholder="UF VOLUME"></td>
						<td><input type="text" name="" id="" value="" placeholder="FLUIDS"></td>
					</tr>
					<tr style="background-color:#e4ffe4;">
						<td class="labeltd">Complications:</td>
						<td colspan="8"><textarea name="remarks" rows="3" cols="100" style="background-color: #d9f1d9;"></textarea></td>
					</tr>
					<tr style="background-color:#ffefff;">
						<td class="labeltd">3rd Hour:</td>
						<td><input type="text" name="" id="" value="" placeholder="BP"></td>
						<td><input type="text" name="" id="" value="" placeholder="PULSE"></td>
						<td><input type="text" name="" id="" value="" placeholder="DELIVERED HEPARIN"></td>
						<td><input type="text" name="" id="" value="" placeholder="BLOOD FLOW RATE"></td>
						<td><input type="text" name="" id="" value="" placeholder="VENOUS PRESSURE"></td>
						<td><input type="text" name="" id="" value="" placeholder="TMP"></td>
						<td><input type="text" name="" id="" value="" placeholder="UF VOLUME"></td>
						<td><input type="text" name="" id="" value="" placeholder="FLUIDS"></td>
					</tr>
					<tr style="background-color:#ffefff;">
						<td class="labeltd">Complications:</td>
						<td colspan="8"><textarea name="remarks" rows="3" cols="100" style="background-color: #f1e1f1;"></textarea></td>
					</tr>
					<tr style="background-color:#ffffc9;">
						<td class="labeltd">4th Hour:</td>
						<td><input type="text" name="" id="" value="" placeholder="BP"></td>
						<td><input type="text" name="" id="" value="" placeholder="PULSE"></td>
						<td><input type="text" name="" id="" value="" placeholder="DELIVERED HEPARIN"></td>
						<td><input type="text" name="" id="" value="" placeholder="BLOOD FLOW RATE"></td>
						<td><input type="text" name="" id="" value="" placeholder="VENOUS PRESSURE"></td>
						<td><input type="text" name="" id="" value="" placeholder="TMP"></td>
						<td><input type="text" name="" id="" value="" placeholder="UF VOLUME"></td>
						<td><input type="text" name="" id="" value="" placeholder="FLUIDS"></td>
					</tr>
					<tr style="background-color:#ffffc9;">
						<td class="labeltd">Complications:</td>
						<td colspan="8"><textarea name="remarks" rows="3" cols="100" style="background-color: #efefbe;"></textarea></td>
					</tr>
					<tr style="background-color:#fff5e8;">
						<td class="labeltd">5th Hour:</td>
						<td><input type="text" name="" id="" value="" placeholder="BP"></td>
						<td><input type="text" name="" id="" value="" placeholder="PULSE"></td>
						<td><input type="text" name="" id="" value="" placeholder="DELIVERED HEPARIN"></td>
						<td><input type="text" name="" id="" value="" placeholder="BLOOD FLOW RATE"></td>
						<td><input type="text" name="" id="" value="" placeholder="VENOUS PRESSURE"></td>
						<td><input type="text" name="" id="" value="" placeholder="TMP"></td>
						<td><input type="text" name="" id="" value="" placeholder="UF VOLUME"></td>
						<td><input type="text" name="" id="" value="" placeholder="FLUIDS"></td>
					</tr>
					<tr style="background-color:#fff5e8;">
						<td class="labeltd">Complications:</td>
						<td colspan="8"><textarea name="remarks" rows="3" cols="100" style="background-color: #f1e7da;"></textarea></td>
					</tr>
					<tr>
						<td colspan="9">
							<label>POST HD ASSESSMENT</label>
							<textarea name="remarks" rows="3" cols="100" ></textarea>
						</td>
					</tr>
				</tbody>
			</table>

		    <hr>

				<h4 class="ui dividing header">POST HD ASSESSMENT</h4>

				<div class="fields">

			  	<div class="seven wide field">
			  		<div class="clinic_code">
			  			<label style="">BLOOD PRESSURE:</label>
			  				<div class="two fields">
			  					<div class="ui labeled input" style="padding-right:5px">
			  						<div class="ui label">Systolic</div>
			  						<input type="text" name="prehd_exit_site" id="prehd_exit_site" value="" >
			  					</div>
			  					<div class="ui labeled input">
			  						<div class="ui label">Diastolic</div>
			  						<input type="text" name="prehd_exit_site" id="prehd_exit_site" value="" >
			  					</div>
			  				</div>
			  		</div>
			  	</div>
			      
			    <div class="three wide field">
						<div class="clinic_code">
							<label style="">T.P.R:</label>
							<input type="text" name="prehd_exit_site" id="prehd_exit_site" value="" >
						</div>
					</div>

				</div>

				<div class="fields">
			    <div class="field">
						<div class="clinic_code">
							<label> POST WEIGHT:</label>
							<input type="text" name="tinzaparin" id="tinzaparin" value="">
						</div>
			    </div>

			    <div class="field">
						<div class="clinic_code">
							<label> WEIGHT LOSS:</label>
							<input type="text" name="tinzaparin" id="tinzaparin" value="">
						</div>
			    </div>

			    <div class="field">
						<div class="clinic_code">
							<label> TERMINATE BY:</label>
							<input type="text" name="tinzaparin" id="tinzaparin" value="">
						</div>
			    </div>
				</div>

				<div class="fields">
			    <div class="field">
						<div class="clinic_code">
							<label> HD ADEQUANCY:</label>
							<input type="text" name="tinzaparin" id="tinzaparin" value="" class="required">
						</div>
			    </div>

			    <div class="field">
						<div class="clinic_code">
							<label> KT/V :</label>
							<input type="text" name="tinzaparin" id="tinzaparin" value="">
						</div>
			    </div>
				</div>
			<div class="ui error message"></div>
		</form>
	</div>
</div>