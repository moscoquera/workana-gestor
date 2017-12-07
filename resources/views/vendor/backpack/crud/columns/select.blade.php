{{-- single relationships (1-1, 1-n) --}}
<td>
	<?php
		if ($entry->{$column['entity']}) {
            $attributes = explode('.',$column['attribute']);
		    $val=$entry->{$column['entity']};

		    foreach ($attributes as $attribute){
		        $val=$val->{$attribute};
            }
	    	if(gettype($val)=='object'){
				if (get_class($val)=='Illuminate\Support\Carbon'){
				    if (isset($column['format'])){
				     $val=$val->format($column['format']);
					}
				}

			}
			echo $val;
	    }
	?>
</td>
