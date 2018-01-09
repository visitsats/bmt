  <div class="floor-layout">
    <div class="table-responsive" id="sub_cat_data">
<?php
	$floor_array=array();
	//echo '<pre>';print_r($available);exit;
	foreach($available as $floor_info1)
	{
		$floor_array[$floor_info1['serial_no']]=$floor_info1;
	}
		//echo '<pre>';print_r($floor_array);exit;
		$arr_array  = array();
		$no_of_columns='';
		if(isset($floor_info[0]['floor_columns']) && $floor_info[0]['floor_columns']!='')
		{
		   $no_of_columns=$floor_info[0]['floor_columns'];
		}
		else
		{
			$no_of_columns=2;		
		}
		
		for( $i = 0; $i < count($floor_info); $i++ ) 
		{
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
		
		foreach( $floor_info as $key => $value ) 
		{
			if ( $i >= $columns ) 
			{
				$output .= '</tr><tr>';
				$i = 0;
				$x++;
			}
			if ( $j <= $columns )
			{
				$class = 'first';
			} 
			else if ( (($amount+$amount_td)-$j) < $columns ) 
			{
				$class = 'last';        
			} 
			else 
			{
				$class = '';
			}
			$n=$i+1;
		
			if(isset($floor_array[$x.''.$n]['serial_no']) && $floor_array[$x.''.$n]['serial_no']!='' && $floor_array[$x.''.$n]['available_status']==1)
			{
				if($floor_array[$x.''.$n]['no_of_seats'] >8 )
				{
					$class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 green';
				}
				else
				{
					if ($floor_array[$x.''.$n]['no_of_seats'] % 2 == 0) 
					{
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' green'; 
					}
					else
					{				
						$number=$floor_array[$x.''.$n]['no_of_seats']+1;
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' green'; 
					}

				}
				if($floor_array[$x.''.$n]['no_of_seats']!=0)
					$table_id=$floor_array[$x.''.$n]['table_id'];
				else
					$table_id='';
					$no_of_seats=$floor_array[$x.''.$n]['no_of_seats'];
					$no_of_seats1=$floor_array[$x.''.$n]['no_of_seats'];
					$table_no=$floor_array[$x.''.$n]['table_no'];
				if($no_of_seats!=0 && $no_of_seats > 8)
					$table_no= "Table ".$table_no;
				else 
					if($no_of_seats!="0" && $no_of_seats <= 8)
					$table_no= "Table ".$table_no;
				else
					$table_no='';
			}
			else
			{
				$table_id='';
				if($floor_array[$x.''.$n]['no_of_seats'] >8 )
				{
					$class='tb '.$floor_array[$x.''.$n]['table_type'].' t8 red'; 
				}
				else
				{
					if ($floor_array[$x.''.$n]['no_of_seats'] % 2 == 0) 
					{				
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$floor_array[$x.''.$n]['no_of_seats'].' red'; 
					}
					else
					{				
						$number=$floor_array[$x.''.$n]['no_of_seats']+1;
						$class='tb '.$floor_array[$x.''.$n]['table_type'].' t'.$number.' red'; 
					}
				}
				$no_of_seats=$floor_array[$x.''.$n]['no_of_seats'];
				$no_of_seats1=$floor_array[$x.''.$n]['no_of_seats'];
				$table_no=$floor_array[$x.''.$n]['table_no'];
				if($no_of_seats!=0 && $no_of_seats > 8)
					$table_no= "Table ".$table_no;
				else
					if($no_of_seats!="0" && $no_of_seats <= 8)
						$table_no= "Table ".$table_no;
					else
						$table_no='';
		
			}
			
			if($floor_array[$x.''.$n]['in_time'] != "")
			{
				$intime = date("g:i A", strtotime($floor_array[$x.''.$n]['in_time']));
			}
			else
			{
				$intime = $floor_array[$x.''.$n]['in_time'];
			}
			
		
			$output.= '<td><b style="font-family:open_sansbold">'.$intime.'</b><div class="'.$class.'" >'.$no_of_seats.'<div class="table-cont">'.$table_no.'</div><div class="hover"></div></div><input type="text" style="display:none" id="click_input_'.$k.'" value="" /><input type="text" style="display:none" value="'.$x.''.$n.'" name="serialno" /></td>
			';
			
			$i++;
			$j++;
			$k++;
		}
		
		$y=$i;
		for( $i = 0; $i < $amount_td; $i++ ) 
		{
			if(isset($floor_array[$x.''.$y]['serial_no']) && $floor_array[$x.''.$y]['serial_no']!='' &&  $floor_array[$x.''.$y]['no_of_seats']!='')
			{
				if($floor_array[$x.''.$y]['no_of_seats'] >8 )
				{
					$class='tb '.$floor_array[$x.''.$y]['table_type'].' t8 green'; 
				}
				else
				{
					$class='tb '.$floor_array[$x.''.$y]['table_type'].' t'.$floor_array[$x.''.$y]['no_of_seats'].' green'; 
				}
				$table_id=$floor_array[$x.''.$y]['table_id'];		
			}
			else
			{
				$table_id='';
				$class='tb rectangle t8 red';
			}
			$output.= '<td><div class="'.$class.'" ><div class="hover"><input type="text" style="display:none" id="click_input_'.$y.'" value="" /><input type="text" style="display:none" value="'.$x.''.$y.'" name="tablenos" /></div></div></td>';
		
			$y++;
		}
		
		$output .= '</tr>
		</table>';
      
			echo $output;
		 
		 ?>
		 </div>
		 </div>
