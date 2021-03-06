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


			$meats = array('abalone', 
							'alligator',
							'bacon',
							'badger',
							'bass',
							'balut',
							'beef',
							'bison',
							'buffalo',
							'capon',
							'cat',
							'chicken',
							'chucker',
							'clams',
							'cod',
							'conch',
							'corned beef',
							'Cornish hen',
							'crab',
							'crawfish',
							'cuttlefish',
							'deviled meats',
							'dog',
							'dove',
							'dried beef',
							'duck',
							'duckling',
							'eels',
							'elk',
							'fish',
							'foie gras',
							'frankfurters',
							'frog legs',
							'gerbil',
							'goat',
							'goose',
							'grouse',
							'guinea fowl',
							'guinea pig',
							'gulls',
							'ham',
							'hamburger',
							'hamster',
							'hare',
							'herring',
							'horsemeat',
							'jerky',
							'kangaroo',
							'kidney',
							'kippers',
							'lamb',
							'liver',
							'lobster',
							'monkey',
							'moose',
							'mussels',
							'mutton',
							'octopus',
							'blankmuse',
							'opossum',
							'oysters',
							'partridge',
							'pea fowl',
							'pemmican',
							'periwinkle',
							'pheasant',
							'pigeon',
							'pork',
							'pork roll',
							'prairie chicken',
							'prawns',
							'ptarmigan',
							'puffin',
							'quail',
							'rabbit',
							'raccoon ',
							'rattlesnake meat',
							'reindeer',
							'rook',
							'salmon',
							'salted meats',
							'sardines',
							'sashimi',
							'sausage',
							'scallops',
							'scrapple',
							'seal',
							'sharkmeat',
							'shrimp',
							'smoked meats',
							'snails',
							'snake',
							'Spam',
							'sparrow',
							'squab',
							'squid',
							'squirrel',
							'swan',
							'sweetbreads',
							'terrapin',
							'tilapia',
							'tendon',
							'tongue',
							'tripe',
							'trout',
							'tuna',
							'turkey',
							'turtle',
							'uni',
							'veal',
							'venison',
							'whelk',
							'wild boar',
							'wild duck',
							'wild goose');

			// echo gettype($json['hits'][0]['_source']['nf_ingredient_statement']);
	
			$warning = false;
			$ingredients = $json['hits'][0]['_source']['nf_ingredient_statement'];
			$item_name = $json['hits'][0]['_source']['item_name'];
			if($newData['allergen']){
				if ((strpos($ingredients, $newData['allergen']) !== false) || (strpos($ingredients, ucfirst($newData['allergen']))) || (strpos($ingredients, strtolower($newData['allergen'])))) {
				    echo '<div class="span6"><div class="alert"><strong>Warning! </strong> Contains '. $newData['allergen'] .'.</div><div class="warning"><i class="icon-warning-sign icon-5"></i></div></div>';
				    $warning = true;
				}
			}

			if($newData['vegetarian'] == 'vegetarian'){
				$hasMeat = false;
				foreach ($meats as $meat){
					// if ((strpos($ingredients, $meat) !==false) || (strpos($ingredients, ucfirst($meat)) !==false) || (strpos($ingredients, strtolower($meat)) !==false) || (strpos($ingredients, strtolower($item_name)) !==false) || (strpos($ingredients, ucfirst($item_name)) !==false)){
					// 	echo '<div class="span6"><div class="alert"><strong>Warning!</strong>Contains meat product.</div><div class="warning"><i class="icon-warning-sign icon-5"></i></div></div>';
					// }
					if ((strpos($item_name, strtolower($meat)) !==false) || (strpos($item_name, ucfirst($meat)) !==false)
						||
						(strpos($ingredients, strtolower($meat)) !==false) || (strpos($ingredients, ucfirst($meat)) !==false)){
						$hasMeat = true;
						$warning = true;
					}
				}
				if ($hasMeat == true){
					echo '<div class="span6"><div class="alert"><strong>Warning! </strong>Contains meat product.</div><div class="warning"><i class="icon-warning-sign icon-5"></i></div></div>';
				}
			};


			if($newData['build-muscle'] == 'build-muscle' and $warning==false and ($json['hits'][0]['_source']['nf_calories']>0)){
				$protein_density= ($json['hits'][0]['_source']['nf_protein']/50*100)/($json['hits'][0]['_source']['nf_calories']/2000*100);
				if($protein_density>=7.6){
					echo '<div class="span6 grade">A+</div>';
				}
				elseif ($protein_density<7.6 and $protein_density>=3.4) {
					echo '<div class="span6 grade">A-</div>';
				}
				elseif ($protein_density<3.4 and $protein_density>=1.5) {
					echo '<div class="span6 grade">B</div>';
				}
				elseif ($protein_density<1.5 and $protein_density>=1.0) {
					echo '<div class="span6 grade">C</div>';
				}
				elseif ($protein_density<1.0 and $protein_density>=0.5) {
					echo '<div class="span6 grade">D</div>';
				}
				else{
					echo '<div class="span6 grade">F</div>';
				}
			}

exit;
?>