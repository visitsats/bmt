  <div class="floor-layout">
    <div class="table-responsive">
 <?php
	$floor_array=array();
	foreach($floor_info as $floor_info1)
	{
	$floor_array[$floor_info1['serial_no']]=$floor_info1;
	}
	//echo '<pre>';print_r($floor_array);
		 $arr_array  = array();
		   $no_of_columns='';
		if(isset($floor_info[0]['floor_columns']) && $floor_info[0]['floor_columns']!='')
		{
		   $no_of_columns=$floor_info[0]['floor_columns'];
		}else
		{
		 $no_of_columns=2;
		
		}
		for( $i = 0; $i < count($floor_info); $i++ ) {
		$arr_array[$i] = $i+1;
		}
		$columns    = $no_of_columns;                                                 
		$amount     = count($arr_array);                                
		$amount_td  = $columns * (ceil( $amount / $columns )) - $amount;  
		$i          = 0;
		$j          = 1;
		$k=1;
		$output='';
		$output.= '<table>
		<tr>';
		$x=1;
		foreach( $floor_info as $key => $value ) {
		if ( $i >= $columns ) {
		$output .= '</tr><tr>';
		$i = 0;
		$x++;
		}
		if ( $j <= $columns ) {
		$class = 'first';
		} else if ( (($amount+$amount_td)-$j) < $columns ) {
		$class = 'last';        
		} else {
		$class = '';
		}
		$n=$i+1;
		
		if(isset($floor_array[$x.''.$n]['table_type']) && $floor_array[$x.''.$n]['table_type']!='')
		{
		 if($floor_array[$x.''.$n]['no_of_seats']>8)
		 {
		 $class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 green';
		 }else
		 {
		 
		 $class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' green';

		 }
		
		}else
		{
		$class='tb rectangle six green';
		}
		
		$output.= '<td><div class="'.$class.'" id="change_color_'.$k.'"><div class="hover"><a href="javascript:void(0)" id="click_model_'.$k.'" title="'.$x.'" onclick="click_model('.$k.')" data-toggle="modal" data-target="#myModal_'.$k.'"  class="btn btn-sm btn-default">Edit</a></div></div><input type="text" style="display:none" id="click_input_'.$k.'" value="" /><input type="text" style="display:none" value="'.$x.''.$n.'" name="serialno" /></td>
		';
		$i++;
		$j++;
        $k++;
		}
		$y=$i;
		for( $i = 0; $i < $amount_td; $i++ ) {
		
		$output.= '<td class="'.$class.'" style="width:50px"><a href="javascript:void(0)"  data-toggle="modal" title="'.$x.'" id="click_model_'.$y.'" onclick="click_model('.$y.')"data-target="#myModal_'.$y.'" class="edittable">Add</a><input type="text" style="display:none" id="click_input_'.$y.'" value="" /><input type="text" style="display:none" value="'.$x.''.$y.'" name="tablenos" /></td>';
		
		$y++;
		}
		$output .= '</tr>
		</table>';
       echo $output;
		 
		 ?>
		 </div>
		 </div>