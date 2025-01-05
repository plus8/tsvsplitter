<?php


$nl = "<BR>";
$lf = "\n";

?>
<html>
<head>
<title>TSV Splitter</title>
<style>
BODY
{ font: normal 14px verdana, arial; line-height: 150%; }

TD
{ font: normal 12px verdana; background-color: #efefef; padding: 2px; }
</style>
</head>
<body>
<div style="font-size: 18px; padding-bottom: 12px; "><b>TSV Spreadsheet Splitter</b> (Tab Separated Values)</div>

Hello, welcome to tsvsplitter mk2<br>
<br>

<?php

$source = $_POST['source'];
$source = trim($source);
$dest1  = $_POST['dest1'];
$dest2  = $_POST['dest2'];

$clearsel  = $_POST['clearsel'];
$showcols  = $_POST['showcols'];
$searchcol = $_POST['searchcol'];
$search    = $_POST['search'];
$search    = trim($search);


if ( !$showcols )
   { $showcols = 70; }


//echo "<hr>";
//foreach ( $_POST as $key=>$value )
//   {
//   if ( $key <> "source" )
//      {
//      echo $key . ": " . $value . $nl;   
//      }
//   }
//echo "<hr>";


?>

Copy and paste the cells from Excel then hit this button to process them.
This was initially written to separate my paypal history hence the occasional
paypal-orientated bits, and since then it's been expanded to works on other data too.<br>

<form method=post name=tsvinput id=tsvinput>
<textarea name=source id=tsvsource cols=80 rows=10 style="width: 100%"><?php echo $source ?></textarea><br>


<div style="padding-top: 8px; padding-bottom: 8px; ">
<input type=checkbox name=clearsel id=clearsel value=yes>
<label for="clearsel">Clear selection</label>
&nbsp;&nbsp;
<input type=button value="clear search" onclick="document.getElementById('tsvsearch').value='';">
Search: 
<input type=text name=search id=tsvsearch value="<?php echo $search ?>">
<input type=submit value="Process">
</div>

<?php
if ( $_POST['clearsel'] == "yes" )
   { $clearsel = true; echo "Clearing selection" . $nl; }
?>
<div style="">Please note the search is <b>case sensitive</b> and <b>additive</b></div>


<br>
<input type=button disabled id=scrolltobottom value="Scroll to bottom" onclick="window.scrollTo(0, 1000000000);" title="Scroll directly to the bottom"> 
&nbsp;&nbsp;
<input type=button value="Select none" onclick="select_no_rows();" title="This can take a while to complete if you have a lot of rows"> 
<input type=button value="Select all" onclick="select_all_rows();" title="This can take a while to complete if you have a lot of rows"> 
<?php

echo "<table border=0 cellspacing=2 cellpadding=2>\n";

$selrows = 0;

$sourcee = explode("\n", $source);

$rowsfound = count($sourcee);
echo "Rows found: " . $rowsfound . " // ";
echo "Rows selected: <span id=selrows></span> // ";
echo "Show cols: " . $showcols . " // ";


$cnt = 0;

$cell_highlight = "background-color: #ddddff; ";

$tmp = "";


foreach ( $sourcee as $line )
   {
   $cntc = 0;
   $checked = "";
   $tmp = "";
   echo "<tr>\n";
   
   if (strval($line) <> "" )
      {
      $cells = explode("\t", $line);
      
      $insearch = "";
      
      if ( $search <> "" )
         {
         foreach ( $cells as $cell )
            {
            $found = strpos($cell, $search);
            if ( $found > -1 && !$clearsel )
               {
               // echo "FOUND IT: " . $found . $nl;
               $checked = "CHECKED"; $tmp = $cell_highlight;; 
               }
            $cntc++;
            } 
         
         }
      
      if ( $_POST['row_' . $cnt] == "yes" && !$clearsel )
         { $checked = "CHECKED"; $tmp = $cell_highlight;}
      
      
      if ( $checked == "CHECKED" )
         {
         $selrows++; 
         }
         
      echo "<td align=left class=\"table_row_" . $cnt . "\" style=\"" . $tmp . "\">";
      echo "<input type=checkbox class=results_checkboxes name=row_" . $cnt . " id=row_" . $cnt . " value=yes " . $checked . " onclick=\"highlightrow(" . $cnt . "); \">";
      echo "</td>\n";
      
      echo "<td align=left class=\"table_row_" . $cnt . "\" style=\"" . $tmp . "\" onclick=\" highlightrow_td(" . $cnt . "); \">" . $cnt . "</td>\n";
      
   
      
      //$celle = explode("\t", $line);
      foreach ( $cells as $cell )
         {
         echo "<td class=\"table_row_" . $cnt . "\" style=\"" . $tmp . "\" onclick=\"highlightrow_td(" . $cnt . ")\">" . $cell . "</td>\n";
         $cntc++;
         }
      echo "</tr>\n";
      
      if ( $checked == "CHECKED" )
         { $dest2 .= $line . "\n"; }
      else
         { $dest1 .= $line . "\n"; }
      }   
   //echo $line . $nl;
   $cnt++;
   }

echo "</table>\n";


echo "Selected rows: " . $selrows . $nl;


echo "
<script language=javascript>

document.getElementById('selrows').innerHTML = '" . $selrows . "';

function highlightrow(r)
   {
   console.log('in highlight row');
   cells = document.getElementsByClassName('table_row_'+r);
   var c = document.getElementById('row_'+r);
   //alert(c.checked);
   //alert(cells.length);
   var t = '';
   for ( i=0; i<cells.length; i++ )
      {
      t = t + cells[i].tagName + '\\n';
      if ( c.checked )
         { cells[i].style.backgroundColor = '#ddddff'; }
      else
         { cells[i].style.backgroundColor = '#efefef'; }
      }
   //alert(t);
   count_selected_rows()
   }


function highlightrow_td(r)
   {
   console.log('in highlight row');
   cells = document.getElementsByClassName('table_row_'+r);
   var c = document.getElementById('row_'+r);
   //alert(c.checked);
   if ( c.checked )
      { c.checked = false; }
   else
      { c.checked = true; }
      
   //alert(cells.length);
   var t = '';
   for ( i=0; i<cells.length; i++ )
      {
      t = t + cells[i].tagName + '\\n';
      if ( c.checked )
         { cells[i].style.backgroundColor = '#ddddff'; }
      else
         { cells[i].style.backgroundColor = '#efefef'; }
      }
   //alert(t);
   count_selected_rows();
   }
   

   
   
function count_selected_rows()
   {
   var c = document.getElementsByClassName('results_checkboxes');
   var selected = 0;
   for ( i=0; i<c.length; i++ )
      {
      if ( c[i].checked )
         { selected++; }
      }
   document.getElementById('selrows').innerHTML = selected;
   }

   
   
function select_no_rows()
   {
   var c = document.getElementsByClassName('results_checkboxes');
   var selected = 0;
   for ( i=0; i<c.length; i++ )
      {
      if ( c[i].checked )
         {
         c[i].checked = false;
         cells = document.getElementsByClassName('table_row_'+i);
         //alert(cells.length);
         for ( j=0; j<cells.length; j++ ) 
            { cells[j].style.backgroundColor = '#efefef'; }
         }
      }
   selected = count_selected_rows();
   document.getElementById('selrows').innerHTML = selected;
   }

   
   
function select_all_rows()
   {
   var c = document.getElementsByClassName('results_checkboxes');
   var selected = 0;
   for ( i=0; i<c.length; i++ )
      {
      
      if ( !c[i].checked )
         {
         c[i].checked = true;
         cells = document.getElementsByClassName('table_row_'+i);
         //alert(cells.length);
         for ( j=0; j<cells.length; j++ ) 
            { cells[j].style.backgroundColor = '#ddddff'; }
         }
      }
   selected = count_selected_rows();
   document.getElementById('selrows').innerHTML = selected;
   }  



function recycle_dest1()
   {
   //tsvinput
   //tsvsource
   //tsvdest1
   // clearsel
   if ( window.confirm('Recycle this output into the input?') )
      {
      document.getElementById('clearsel').checked = true
      document.getElementById('tsvsource').value = '';
      document.getElementById('tsvsource').value = document.getElementById('tsvdest1').value
      document.getElementById('tsvsearch').value = '';
      document.getElementById('tsvinput').submit();
      }
   }

 

function recycle_dest2()
   {
   //tsvinput
   //tsvsource
   //tsvdest1
   // clearsel
   //alert('recycling dest 1');
   if ( window.confirm('Recycle this output into the input?') )
      {
      document.getElementById('clearsel').checked = true
      document.getElementById('tsvsource').value = '';
      document.getElementById('tsvsource').value = document.getElementById('tsvdest2').value
      document.getElementById('tsvsearch').value = '';
      document.getElementById('tsvinput').submit();
      }
   } 
   
document.getElementById('scrolltobottom').disabled = false;


function copydest1()
   {
   let textarea = document.getElementById('tsvdest1');
   textarea.select();
   document.execCommand('copy');
   //alert('Output copied, please paste into a spreadsheet');
   }

   
function copydest2()
   {
   let textarea = document.getElementById('tsvdest2');
   textarea.select();
   document.execCommand('copy');
   //alert('Output copied, please paste into a spreadsheet');
   }
   
</script>";

?>
Once you're happy with your selection, process again to output the separated tables.<br>
<br>
<input type=button value="Scroll to top" onclick="window.scrollTo(0, 0)" title="Scroll directly to the top">
&nbsp;&nbsp;
<input type=submit value="Process"><br>
<br>
<b>ALWAYS PROCESS ONE LAST TIME TO MAKE SURE THE SELECTION IS UDPATED TO THE OUTPUT BOXES</b><br>

</form>
Not selected:<br>
<textarea name=dest1 id=tsvdest1 cols=80 rows=10 style="width: 100%"><?php echo $dest1 ?></textarea><br>
<input type=button value="Recycle this output into the input" onclick="recycle_dest1()">
&nbsp;&nbsp;&nbsp;
<input type=button value="Click to copy this output" onclick="copydest1()">
<br><br><br>

Selected: <br>
<textarea name=dest2 id=tsvdest2 cols=80 rows=10 style="width: 100%"><?php echo $dest2 ?></textarea><br>
<input type=button value="Recycle this output into the input" onclick="recycle_dest2()">
&nbsp;&nbsp;&nbsp;
<input type=button value="Click to copy this output" onclick="copydest2()">
<br><br><br>

<span style="font-size: 11px;">Created under duress 15/1/2023 because the old ASP version can't handle some of the characters and keeps breaking</span><br>


</body>
</html>
<?php



