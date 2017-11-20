{{-- single relationships (1-1, 1-n) --}}
<td>
	<?php
		if ($entry->{$column['entity']}) {
		    $attributes = explode('.',$column['attribute']);
		    $val=$entry->{$column['entity']};
		    foreach ($attributes as $attribute){
		        $val=$val->{$attribute};
            }
	    	echo $val;
	    }
	?>
</td>
