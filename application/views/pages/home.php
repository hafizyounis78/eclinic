<div class="row">
    <div class="col-md-12">
    	<table class="table table-striped table-hover table-bordered" id="accordion2">
          <thead>
            <tr class="bg-grey-steel">
                <th scope="col">
                     &nbsp;
                </th>
                <th scope="col">
                  الفـطــــور
                </th>
                <th scope="col">
                  الغـــــداء
                </th>
                <th scope="col">
                  العشـــــاء
                </th>
                <th scope="col">
                  &nbsp;
                </th>
            </tr>
          </thead>
          <tbody>
          	<tr>
            	<td>اليوم الأول</td>
                <td><textarea name="txtbreakfast" id="txtbreakfast" cols="70" rows="5" class="form-control"><?php if(isset($plan_row->breakfast)) echo $plan_row->breakfast;?></textarea></td>
                <td><textarea name="txtlunch" id="txtlunch" cols="70" rows="5" class="form-control"><?php if(isset($plan_row->lunch)) echo $plan_row->lunch;?></textarea></td>
                <td> <textarea name="txtdinner" id="txtdinner" cols="70" rows="5" class="form-control"><?php if(isset($plan_row->dinner)) echo $plan_row->dinner;?></textarea></td>
                <td><button id="btnAddTest" name="btnAddTest" type="button" class="btn btn-circle green-turquoise btn-sm" onclick="addResult('.$itemrow->lab_order_results_id.')">
						<i id="iConst" class="fa fa-plus"></i></button></td>
            </tr>
            <tr>
            	<td>اليوم الثاني</td>
                <td><textarea name="txtbreakfast" id="txtbreakfast" cols="70" rows="5" class="form-control"><?php if(isset($plan_row->breakfast)) echo $plan_row->breakfast;?></textarea></td>
                <td><textarea name="txtlunch" id="txtlunch" cols="70" rows="5" class="form-control"><?php if(isset($plan_row->lunch)) echo $plan_row->lunch;?></textarea></td>
                <td> <textarea name="txtdinner" id="txtdinner" cols="70" rows="5" class="form-control"><?php if(isset($plan_row->dinner)) echo $plan_row->dinner;?></textarea></td>
                <td><button id="btnAddTest" name="btnAddTest" type="button" class="btn btn-circle green-turquoise btn-sm" onclick="addResult('.$itemrow->lab_order_results_id.')">
						<i id="iConst" class="fa fa-plus"></i></button></td>
            </tr>
          </tbody>
        </table>
    </div>
</div>