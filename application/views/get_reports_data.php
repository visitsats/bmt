  <div class="floor-layout">
    <div class="table-responsive" id="sub_cat_data">
 <?php
	$floor_array=array();
	
	foreach($available as $floor_info1)
	{
	$floor_array[$floor_info1['serial_no']]=$floor_info1;
	}

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
		
		if(isset($floor_array[$x.''.$n]['serial_no']) && $floor_array[$x.''.$n]['serial_no']!='')
		{
	    if($floor_array[$x.''.$n]['no_of_seats'] >8 )
		{
				$class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 green'; 

		}else
		{
				$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' green'; 

		}
		$table_id=$floor_array[$x.''.$n]['table_id'];

		
		}else
		{
		 $table_id='';
		 $class='tb rectangle t8 red';

		}
		
		$output.= '<td><div class="'.$class.'" ><div class="hover"></div></div></td>
		';
		$i++;
		$j++;
        $k++;
		}
		$y=$i;
		for( $i = 0; $i < $amount_td; $i++ ) {
		if(isset($floor_array[$x.''.$y]['serial_no']) && $floor_array[$x.''.$y]['serial_no']!='')
		{
	    if($floor_array[$x.''.$y]['no_of_seats'] >8 )
		{
				$class='tb '.$floor_array[$x.''.$y]['table_type'].' t8 green'; 

		}else
		{
				$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$floor_array[$x.''.$y]['no_of_seats'].' green'; 

		}
		$table_id=$floor_array[$x.''.$y]['table_id'];

		
		}else
		{
		 $table_id='';
		 $class='tb rectangle t8 red';

		}
		$output.= '<td class="'.$class.'" style="width:50px"></td>';
		
		$y++;
		}
		$output .= '</tr>
		</table>';
       echo $output;
		 
		 ?>
		 </div>
		 </div>
