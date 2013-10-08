<?
if (isset($_POST['param']) && trim($_POST['param']) != ''){
	parse_str(trim($_POST['param']), $newData);
	$newData['item_name'] = trim($newData['item_name']);
	$newData['item_name'] .= '';
	if ($newData['item_name'] == '')
		$data = array('result' => 'fail');
	else{
		require_once ('../nutritionix.v1.1.php');
		$nutritionix = new Nutritionix();
		$data = $nutritionix -> search($newData['item_name']);
	}
}else
	$data = array('result' => 'fail');

if ( (bool)$newData['return_result_as_json'] ){
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-Type: application/json');
	echo json_encode($data);
}else
	$json = (json_encode( (array)$data));
	$json = json_decode($json, true);
	echo '
	<div class="span5">
		<p class="lead">'.$json['hits'][0]['_source']['item_name'].'</p>
		<table class="nutrition" summary="This table summarizes nutritional information">
						<tbody><tr>
							<th colspan="2">Nutrition Facts</th>
						</tr>
						<tr id="servings">
							<td colspan="2">Serving Size '. $json['hits'][0]['_source']['nf_serving_size_qty'] .'</td>
						</tr>
						<tr>
							<td colspan="2">Amount Per Serving</td>
						</tr>
						<tr id="calories">
							<td><strong>Calories</strong> '. $json['hits'][0]['_source']['nf_calories'] .'</td>
							<td>Calories from Fat '. $json['hits'][0]['_source']['nf_calories_from_fat'] .'</td>
						</tr>
						<tr>
							<td></td>
							<td class="dv">% Daily Value *</td>
						</tr>
						<tr>
							<td><strong>Total Fat</strong> '. $json['hits'][0]['_source']['nf_total_fat'] .'g</td>
							<td class="dv">'. round($json['hits'][0]['_source']['nf_total_fat']/65*100,0) .'%</td>
						</tr>
						<tr>
							<td class="sub">Saturated Fat '. $json['hits'][0]['_source']['nf_saturated_fat']  .'g</td>
							<td class="dv">'. round($json['hits'][0]['_source']['nf_saturated_fat']/20*100,0) .'%</td>
						</tr>
						<tr>
							<td class="sub">Trans Fat '. $json['hits'][0]['_source']['nf_trans_fatty_acid'] .'g</td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Cholesterol</strong> '. $json['hits'][0]['_source']['nf_cholesterol'] .'mg</td>
							<td class="dv">'. round($json['hits'][0]['_source']['nf_cholesterol']/300*100,0).'%</td>
						</tr>
						<tr>
							<td><strong>Sodium</strong> '. $json['hits'][0]['_source']['nf_sodium'] .'mg</td>
							<td class="dv">'.round($json['hits'][0]['_source']['nf_sodium']/2400*100,0).'%</td>
						</tr>
						<tr>
							<td><strong>Total Carbohydrate</strong> '. $json['hits'][0]['_source']['nf_total_carbohydrate'] .'g</td>
							<td class="dv">'.round($json['hits'][0]['_source']['nf_total_carbohydrate']/300*100,0).'%</td>
						</tr>
						<tr>
							<td class="sub">Dietary Fiber '. $json['hits'][0]['_source']['nf_dietary_fiber'] .'g</td>
							<td class="dv">'.round($json['hits'][0]['_source']['nf_dietary_fiber']/25*100,0).'%</td>
						</tr>
						<tr>
							<td class="sub">Sugars '. $json['hits'][0]['_source']['nf_sugars'] .'g</td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Protein</strong> '. $json['hits'][0]['_source']['nf_protein'] .'g</td>
							<td class="dv">'.round($json['hits'][0]['_source']['nf_protein']/50*100,0).'%</td>
						</tr>
						<tr id="minerals">
							<td>Vitamin A</td>
							<td class="dv">'. $json['hits'][0]['_source']['nf_vitamin_a_dv'] .'%</td>
						</tr>
						<tr>
							<td>Vitamin C</td>
							<td class="dv">'. $json['hits'][0]['_source']['nf_vitamin_c_dv'] .'%</td>
						</tr>
						<tr>
							<td>Calcium</td>
							<td class="dv">'. $json['hits'][0]['_source']['nf_calcium_dv'] .'%</td>
						</tr>
						<tr>
							<td>Iron</td>
							<td class="dv">'. $json['hits'][0]['_source']['nf_iron_dv'] .'%</td>
						</tr>
						<tr>
							<td id="disclaimer" colspan="2">
					* The Percent Daily Values are based on a 2,000 calorie diet, so your values may change depending on your calorie needs.
					The values here may not be 100% accurate because the recipes have not been professionally evaluated nor have they been evaluated by the U.S. FDA.	
							</td>
						</tr>
					</tbody>
				</table>
			</div>';

			// echo gettype($json['hits'][0]['_source']['nf_ingredient_statement']);

			$ingredients = $json['hits'][0]['_source']['nf_ingredient_statement'];
			if($newData['allergen']){
				if ((strpos($ingredients, $newData['allergen']) !== false) || (strpos($ingredients, ucfirst($newData['allergen']))) || (strpos($ingredients, strtolower($newData['allergen'])))) {
				    echo '<div class="span6"><div class="alert"><strong>Warning!</strong> Contains '. $newData['allergen'] .'.</div><div class="warning"><i class="icon-warning-sign icon-5"></i></div></div>';
				}
			}

exit;
?>