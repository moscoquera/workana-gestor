<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 12/14/17
 * Time: 8:34 PM
 */
?>

<td>
    @if ($entry->{$column['name']})
        <ul>
        @foreach($entry->{$column['name']} as $file)
                <?php $file=explode('|',$file); ?>
                <li><a href="{{ url('/uploads/'.$file[1]) }}" title="{{ $file[0] }}" target="_blank" >{{ str_limit($file[0],20,'...') }}</a></li>
        @endforeach
        </ul>
    @endif
</td>
