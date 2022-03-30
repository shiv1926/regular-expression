<?php 
function es_url($file='')
{
    if($_SERVER['HTTP_HOST']=='shiv-pc') {
        return 'http://shiv-pc/all_tutorials/javascript/es6/'.$file;
    } else {
        return 'http://localhost/all_tutorial/javascript/es6/'.$file;
    }
}

function refrences($links)
{
    $return='<div>&nbsp;</div>';
    $return.='<h4>Refrences</h4>';
    foreach($links as $link)
    {
        $return.='<div><a href="'.$link.'" target="_blank">'.$link.'</a></div>';
    }
    return $return;
}

function example_formatted($ex)
{
    $return=array(); $script = array(); $expln_array = array(); $example_array = array(); $program = ''; $explaination = '';
    $file = fopen($ex, 'r');
    $counter = 0;
    if($file)
    {
        while(!feof($file))
        {
            $line = fgets($file);
            $temp = strtolower(trim($line));
            $example_array[] = $line;
            if($temp=='<script>') {
                $script['start_index'] = $counter;
            }
            if($temp=='</script>') {
                $script['end_index'] = $counter;
            }
            if($temp=='<explaination>') {
                $expln_array['start_index'] = $counter;
            }
            if($temp=='</explaination>') {
                $expln_array['end_index'] = $counter;
            }
            $counter++;
        }
    }
    fclose($file);
    $program.="<pre>";  $output = '';
    for($i = $script['start_index']; $i<=$script['end_index']; $i++)
    {
        $line = htmlspecialchars($example_array[$i]);
        $program.='<div>'.$line.'</div>';
        $output.=$example_array[$i];
    }
    $program.="</pre>";

    if(!empty($expln_array))
    {
        for($i = $expln_array['start_index'] + 1; $i<$expln_array['end_index']; $i++)
        {
            $explaination.=$example_array[$i];
        }
    }

    $return['program'] = $program;
    $return['explaination'] = $explaination;
    $return['output'] = $output;
    return $return;
}

function example_with_output($ex)
{
    $example = example_formatted($ex);
    $return='';
    $return.='<div class="example_output">';
    $return.='<div class="ex_progam">'.$example['program'].'</div>';
    $return.='<div class="ex_expln">';
    $return.='<div class="line1">For output <a href="'.es_url($ex).'" target="_blank">Click here</a></div>';
    if($example['explaination']!='') {
        $return.='<div class="line2">'.$example['explaination'].'</div>';
    }
    $return.='</div>';
    $return.='</div>';
    return $return;
}
?>