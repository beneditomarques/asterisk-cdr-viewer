<div id="main">
<table class="cdr">
<tr>
<td>

<form method="post" enctype="application/x-www-form-urlencoded" action="?">
<fieldset>
<legend class="title">Relatório de detalhamento de chamadas (Busca)</legend>
<table width="100%">
<tr>
<th>Order By</th>
<th>Filtros</th>
<th>&nbsp;</th>
</tr>
<tr>
<td><input <?php if (empty($_REQUEST['order']) || $_REQUEST['order'] == 'calldate') { echo 'checked="checked"'; } ?> type="radio" name="order" value="calldate" />&nbsp;Data:</td>
<td>Início:
<input type="text" name="startday" id="startday" size="2" maxlength="2" value="<?php if (isset($_REQUEST['startday'])) { echo htmlspecialchars($_REQUEST['startday']); } else { echo '01'; } ?>" />
<select name="startmonth" id="startmonth">
<?php
$months = array('01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro');
foreach ($months as $i => $month) {
	if ((is_blank($_REQUEST['startmonth']) && date('m') == $i) || (isset($_REQUEST['startmonth']) && $_REQUEST['startmonth'] == $i)) {
		echo "        <option value=\"$i\" selected=\"selected\">$month</option>\n";
	} else {
		echo "        <option value=\"$i\">$month</option>\n";
	}
}
?>
</select>
<select name="startyear" id="startyear">
<?php
for ( $i = 2000; $i <= date('Y'); $i++) {
	if ((empty($_REQUEST['startyear']) && date('Y') == $i) || (isset($_REQUEST['startyear']) && $_REQUEST['startyear'] == $i)) {
		echo "        <option value=\"$i\" selected=\"selected\">$i</option>\n";
	} else {
		echo "        <option value=\"$i\">$i</option>\n";
	}
}
?>
</select>
<input type="text" name="starthour" id="starthour" size="2" maxlength="2" value="<?php if (isset($_REQUEST['starthour'])) { echo htmlspecialchars($_REQUEST['starthour']); } else { echo '00'; } ?>" />
:
<input type="text" name="startmin" id="startmin" size="2" maxlength="2" value="<?php if (isset($_REQUEST['startmin'])) { echo htmlspecialchars($_REQUEST['startmin']); } else { echo '00'; } ?>" />
Final:
<input type="text" name="endday" id="endday" size="2" maxlength="2" value="<?php if (isset($_REQUEST['endday'])) { echo htmlspecialchars($_REQUEST['endday']); } else { echo '31'; } ?>" />
<select name="endmonth" id="endmonth">
<?php
foreach ($months as $i => $month) {
	if ((is_blank($_REQUEST['endmonth']) && date('m') == $i) || (isset($_REQUEST['endmonth']) && $_REQUEST['endmonth'] == $i)) {
		echo "        <option value=\"$i\" selected=\"selected\">$month</option>\n";
	} else {
		echo "        <option value=\"$i\">$month</option>\n";
	}
}
?>
</select>
<select name="endyear" id="endyear">
<?php
for ( $i = 2000; $i <= date('Y'); $i++) {
	if ((empty($_REQUEST['endyear']) && date('Y') == $i) || (isset($_REQUEST['endyear']) && $_REQUEST['endyear'] == $i)) {
		echo "        <option value=\"$i\" selected=\"selected\">$i</option>\n";
	} else {
		echo "        <option value=\"$i\">$i</option>\n";
	}
}
?>
</select>
<input type="text" name="endhour" id="endhour" size="2" maxlength="2" value="<?php if (isset($_REQUEST['endhour'])) { echo htmlspecialchars($_REQUEST['endhour']); } else { echo '23'; } ?>" />
:
<input type="text" name="endmin" id="endmin" size="2" maxlength="2" value="<?php if (isset($_REQUEST['endmin'])) { echo htmlspecialchars($_REQUEST['endmin']); } else { echo '59'; } ?>" />
&nbsp;
&nbsp;
&nbsp;
<select name='ranges' onchange="NewDate(this.value);">
	<option value=''>Atalhos</option>
	<option value='td'>Hoje</option>
	<option value='pd'>Ontem</option>
	<option value='3d'>Últimos 3 dias</option>
	<option value='tw'>Esta semana</option>
	<option value='pw'>Semana passada</option>
	<option value='3w'>Últimas 3 semanas</option>
	<option value='tm'>Este mês</option>
	<option value='pm'>Mês passado</option>
	<option value='3m'>Últimos 3 mêses</option>
</select>
</td>
<td rowspan="13" valign='top' align='right'>
<fieldset>
<legend class="title">Opções extras</legend>
<table>
<tr>
<td>Tipo de relatório : </td>
<td>
<input <?php if ( (empty($_REQUEST['need_html']) && empty($_REQUEST['need_chart']) && empty($_REQUEST['need_chart_cc']) && empty($_REQUEST['need_minutes_report']) && empty($_REQUEST['need_asr_report']) && empty($_REQUEST['need_csv'])) || ( ! empty($_REQUEST['need_html']) &&  $_REQUEST['need_html'] == 'true' ) ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_html" value="true" /> : Busca normal (CDR) <br />
<?php
if ( strlen($callrate_csv_file) > 0 ) {
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="use_callrates" value="true"';
	if ( ! empty($_REQUEST['use_callrates']) &&  $_REQUEST['use_callrates'] == 'true' ) { echo 'checked="checked"'; }
	echo ' /> with call rates<br/>';
} 
if ( isset($cdr_suppress_download_links) and $cdr_suppress_download_links ) {
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="show_download_file" value="true"';
	if ( ! empty($_REQUEST['show_download_links']) &&  $_REQUEST['show_download_links'] == 'true' ) { echo 'checked="checked"'; }
	echo ' /> show download links<br/>';
}
?>
<input <?php if ( ! empty($_REQUEST['need_csv']) && $_REQUEST['need_csv'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_csv" value="true" /> : Arquivo CSV<br/>
<input <?php if ( ! empty($_REQUEST['need_chart']) && $_REQUEST['need_chart'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_chart" value="true" /> : Gráfico de chamadas<br />
<input <?php if ( ! empty($_REQUEST['need_chart_cc']) && $_REQUEST['need_chart_cc'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_chart_cc" value="true" /> : Chamadas simultâneas<br />
<input <?php if ( ! empty($_REQUEST['need_minutes_report']) && $_REQUEST['need_minutes_report'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_minutes_report" value="true" /> : Relatório de minutagem<br />
<input <?php if ( ! empty($_REQUEST['need_asr_report']) && $_REQUEST['need_asr_report'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="need_asr_report" value="true" /> : Relatório ASR/ACD<br />
</td>
</tr>
<?php
if ( count($plugins) > 0 ) {
	echo '<tr><td label for="Plugins">Plugins : </td><td><hr>';
	foreach ( $plugins as &$p_key ) {
		echo '<input type="checkbox" name="need_'.$p_key.'" value="true" ';
		if ( ! empty($_REQUEST['need_'.$p_key]) && $_REQUEST['need_'.$p_key] == 'true' ) { 
			echo 'checked="checked"'; 
		}
		echo ' /> : '. $p_key .'<br />';
	}
	echo '</td></tr>';
}
?>
<tr>
<td><label for="Result limit">Número máximo de linhas : </label></td>
<td>
<hr>
<input value="<?php 
if (isset($_REQUEST['limit']) ) { 
	echo htmlspecialchars($_REQUEST['limit']);
} else {
	echo $db_result_limit;
} ?>" name="limit" size="6" />
</td>
</tr>
</table>
</fieldset>
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'channel') { echo 'checked="checked"'; } ?> type="radio" name="order" value="channel" />&nbsp;<label for="channel">Canal de origem:</label></td>
<td><input type="text" name="channel" id="channel" value="<?php if (isset($_REQUEST['channel'])) { echo htmlspecialchars($_REQUEST['channel']); } ?>" />
<input <?php if ( isset($_REQUEST['channel_neg'] ) && $_REQUEST['channel_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="channel_neg" value="true" /> exceto
<input <?php if (empty($_REQUEST['channel_mod']) || $_REQUEST['channel_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="channel_mod" value="begins_with" />: Começa com,
<input <?php if (isset($_REQUEST['channel_mod']) && $_REQUEST['channel_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="channel_mod" value="contains" />: Contém, 
<input <?php if (isset($_REQUEST['channel_mod']) && $_REQUEST['channel_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="channel_mod" value="ends_with" />: Termina com,
<input <?php if (isset($_REQUEST['channel_mod']) && $_REQUEST['channel_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="channel_mod" value="exact" />: Exato
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'src') { echo 'checked="checked"'; } ?> type="radio" name="order" value="src" />&nbsp;<label for="src">Origem:</label></td>
<td><input type="text" name="src" id="src" value="<?php if (isset($_REQUEST['src'])) { echo htmlspecialchars($_REQUEST['src']); } ?>" />
<input <?php if ( isset($_REQUEST['src_neg'] ) && $_REQUEST['src_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="src_neg" value="true" /> exceto
<input <?php if (empty($_REQUEST['src_mod']) || $_REQUEST['src_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="src_mod" value="begins_with" />: Começa com,
<input <?php if (isset($_REQUEST['src_mod']) && $_REQUEST['src_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="src_mod" value="contains" />: Contém, 
<input <?php if (isset($_REQUEST['src_mod']) && $_REQUEST['src_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="src_mod" value="ends_with" />: Termina com,
<input <?php if (isset($_REQUEST['src_mod']) && $_REQUEST['src_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="src_mod" value="exact" />: Exato
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'clid') { echo 'checked="checked"'; } ?> type="radio" name="order" value="clid" />&nbsp;<label for="clid">Caller*ID</label></td>
<td><input type="text" name="clid" id="clid" value="<?php if (isset($_REQUEST['clid'])) { echo htmlspecialchars($_REQUEST['clid']); } ?>" />
<input <?php if ( isset($_REQUEST['clid_neg'] ) && $_REQUEST['clid_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="clid_neg" value="true" /> exceto
<input <?php if (empty($_REQUEST['clid_mod']) || $_REQUEST['clid_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="clid_mod" value="begins_with" />: Começa com,
<input <?php if (isset($_REQUEST['clid_mod']) && $_REQUEST['clid_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="clid_mod" value="contains" />: Contém, 
<input <?php if (isset($_REQUEST['clid_mod']) && $_REQUEST['clid_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="clid_mod" value="ends_with" />: Termina com,
<input <?php if (isset($_REQUEST['clid_mod']) && $_REQUEST['clid_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="clid_mod" value="exact" />: Exato
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'dst') { echo 'checked="checked"'; } ?> type="radio" name="order" value="dst" />&nbsp;<label for="dst">Destino:</label></td>
<td><input type="text" name="dst" id="dst" value="<?php if (isset($_REQUEST['dst'])) { echo htmlspecialchars($_REQUEST['dst']); } ?>" />
<input <?php if ( isset($_REQUEST['dst_neg'] ) &&  $_REQUEST['dst_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="dst_neg" value="true" /> exceto
<input <?php if (empty($_REQUEST['dst_mod']) || $_REQUEST['dst_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="dst_mod" value="begins_with" />: Começa com,
<input <?php if (isset($_REQUEST['dst_mod']) && $_REQUEST['dst_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="dst_mod" value="contains" />: Contém, 
<input <?php if (isset($_REQUEST['dst_mod']) && $_REQUEST['dst_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="dst_mod" value="ends_with" />: Termina com,
<input <?php if (isset($_REQUEST['dst_mod']) && $_REQUEST['dst_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="dst_mod" value="exact" />: Exato
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'did') { echo 'checked="checked"'; } ?> type="radio" name="order" value="did" />&nbsp;<label for="did">DID (if existst):</label></td>
<td><input type="text" name="did" id="did" value="<?php if (isset($_REQUEST['did'])) { echo htmlspecialchars($_REQUEST['did']); } ?>" />
<input <?php if ( isset($_REQUEST['did_neg'] ) && $_REQUEST['did_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="did_neg" value="true" /> exceto
<input <?php if (empty($_REQUEST['did_mod']) || $_REQUEST['did_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="did_mod" value="begins_with" />: Começa com,
<input <?php if (isset($_REQUEST['did_mod']) && $_REQUEST['did_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="did_mod" value="contains" />: Contém, 
<input <?php if (isset($_REQUEST['did_mod']) && $_REQUEST['did_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="did_mod" value="ends_with" />: Termina com,
<input <?php if (isset($_REQUEST['did_mod']) && $_REQUEST['did_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="did_mod" value="exact" />: Exato
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'dstchannel') { echo 'checked="checked"'; } ?> type="radio" name="order" value="dstchannel" />&nbsp;<label for="dstchannel">Canal de destino:</label></td>
<td><input type="text" name="dstchannel" id="dstchannel" value="<?php if (isset($_REQUEST['dstchannel'])) { echo htmlspecialchars($_REQUEST['dstchannel']); } ?>" />
<input <?php if ( isset($_REQUEST['dstchannel_neg'] ) && $_REQUEST['dstchannel_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="dstchannel_neg" value="true" /> exceto
<input <?php if (empty($_REQUEST['dstchannel_mod']) || $_REQUEST['dstchannel_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="dstchannel_mod" value="begins_with" />: Começa com,
<input <?php if (isset($_REQUEST['dstchannel_mod']) && $_REQUEST['dstchannel_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="dstchannel_mod" value="contains" />: Contém, 
<input <?php if (isset($_REQUEST['dstchannel_mod']) && $_REQUEST['dstchannel_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="dstchannel_mod" value="ends_with" />: Termina com,
<input <?php if (isset($_REQUEST['dstchannel_mod']) && $_REQUEST['dstchannel_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="dstchannel_mod" value="exact" />: Exato
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'userfield') { echo 'checked="checked"'; } ?> type="radio" name="order" value="userfield" />&nbsp;<label for="userfield">Userfield:</label></td>
<td><input type="text" name="userfield" id="userfield" value="<?php if (isset($_REQUEST['userfield'])) { echo htmlspecialchars($_REQUEST['userfield']); } ?>" />
<input <?php if (  isset($_REQUEST['userfield_neg'] ) && $_REQUEST['userfield_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="userfield_neg" value="true" /> exceto
<input <?php if (empty($_REQUEST['userfield_mod']) || $_REQUEST['userfield_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="userfield_mod" value="begins_with" />: Começa com,
<input <?php if (isset($_REQUEST['userfield_mod']) && $_REQUEST['userfield_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="userfield_mod" value="contains" />: Contém, 
<input <?php if (isset($_REQUEST['userfield_mod']) && $_REQUEST['userfield_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="userfield_mod" value="ends_with" />: Termina com,
<input <?php if (isset($_REQUEST['userfield_mod']) && $_REQUEST['userfield_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="userfield_mod" value="exact" />: Exato
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'accountcode') { echo 'checked="checked"'; } ?> type="radio" name="order" value="accountcode" />&nbsp;<label for="userfield">Código de conta:</label></td>
<td><input type="text" name="accountcode" id="accountcode" value="<?php if (isset($_REQUEST['accountcode'])) { echo htmlspecialchars($_REQUEST['accountcode']); } ?>" />
<input <?php if ( isset($_REQUEST['accountcode_neg'] ) &&  $_REQUEST['accountcode_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="accountcode_neg" value="true" /> exceto
<input <?php if (empty($_REQUEST['accountcode_mod']) || $_REQUEST['accountcode_mod'] == 'begins_with') { echo 'checked="checked"'; } ?> type="radio" name="accountcode_mod" value="begins_with" />: Começa com,
<input <?php if (isset($_REQUEST['accountcode_mod']) && $_REQUEST['accountcode_mod'] == 'contains') { echo 'checked="checked"'; } ?> type="radio" name="accountcode_mod" value="contains" />: Contém, 
<input <?php if (isset($_REQUEST['accountcode_mod']) && $_REQUEST['accountcode_mod'] == 'ends_with') { echo 'checked="checked"'; } ?> type="radio" name="accountcode_mod" value="ends_with" />: Termina com,
<input <?php if (isset($_REQUEST['accountcode_mod']) && $_REQUEST['accountcode_mod'] == 'exact') { echo 'checked="checked"'; } ?> type="radio" name="accountcode_mod" value="exact" />: Exato
</td>
</tr>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'duration') { echo 'checked="checked"'; } ?> type="radio" name="order" value="duration" />&nbsp;<label>Duração:</label></td>
<td>Entre:
<input type="text" name="dur_min" value="<?php if (isset($_REQUEST['dur_min'])) { echo htmlspecialchars($_REQUEST['dur_min']); } ?>" size="3" maxlength="5" />
E:
<input type="text" name="dur_max" value="<?php if (isset($_REQUEST['dur_max'])) { echo htmlspecialchars($_REQUEST['dur_max']); } ?>" size="3" maxlength="5" />
Segundos
</td>
</tr>

<?php 
if ( isset($display_column['billsec']) and $display_column['billsec'] == 1 ) {
?>
<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'billsec') { echo 'checked="checked"'; } ?> type="radio" name="order" value="billsec" />&nbsp;<label>Tempo falado:</label></td>
<td>Entre:
<input type="text" name="bill_min" value="<?php if (isset($_REQUEST['bill_min'])) { echo htmlspecialchars($_REQUEST['bill_min']); } ?>" size="3" maxlength="5" />
E:
<input type="text" name="bill_max" value="<?php if (isset($_REQUEST['bill_max'])) { echo htmlspecialchars($_REQUEST['bill_max']); } ?>" size="3" maxlength="5" />
Segundos
</td>
</tr>
<?php
};?>

<tr>
<td><input <?php if (isset($_REQUEST['order']) && $_REQUEST['order'] == 'disposition') { echo 'checked="checked"'; } ?> type="radio" name="order" value="disposition" />&nbsp;<label for="disposition">Disposição:</label></td>
<td nowrap=""nowrap>
<input <?php if ( isset($_REQUEST['disposition_neg'] ) && $_REQUEST['disposition_neg'] == 'true' ) { echo 'checked="checked"'; } ?> type="checkbox" name="disposition_neg" value="true" /> exceto
<select name="disposition" id="disposition">
<option <?php if (empty($_REQUEST['disposition']) || $_REQUEST['disposition'] == 'all') { echo 'selected="selected"'; } ?> value="all">Todas as disposições</option>
<option <?php if (isset($_REQUEST['disposition']) && $_REQUEST['disposition'] == 'ANSWERED') { echo 'selected="selected"'; } ?> value="ANSWERED">Atendidas</option>
<option <?php if (isset($_REQUEST['disposition']) && $_REQUEST['disposition'] == 'BUSY') { echo 'selected="selected"'; } ?> value="BUSY">Ocupadas</option>
<option <?php if (isset($_REQUEST['disposition']) && $_REQUEST['disposition'] == 'FAILED') { echo 'selected="selected"'; } ?> value="FAILED">Falha</option>
<option <?php if (isset($_REQUEST['disposition']) && $_REQUEST['disposition'] == 'NO ANSWER') { echo 'selected="selected"'; } ?> value="NO ANSWER">Não atendidas</option>
</select>
</td>
</tr>
<tr>
<td>
<select name="sort" id="sort">
<option <?php if (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'ASC') { echo 'selected="selected"'; } ?> value="ASC">Ascendente</option>
<option <?php if (empty($_REQUEST['sort']) || $_REQUEST['sort'] == 'DESC') { echo 'selected="selected"'; } ?> value="DESC">Descendente</option>
</select>
</td>
<td><table width="100%"><tr><td>
<label for="group">Agrupar por:</label>
<select name="group" id="group">
<optgroup label="Account Information">
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'accountcode') { echo 'selected="selected"'; } ?> value="accountcode">Código de conta</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'userfield') { echo 'selected="selected"'; } ?> value="userfield">UserField</option>
</optgroup>
<optgroup label="Date/Time">
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'minutes1') { echo 'selected="selected"'; } ?> value="minutes1">Minuto</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'minutes10') { echo 'selected="selected"'; } ?> value="minutes10">10 Minutos</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'hour') { echo 'selected="selected"'; } ?> value="hour">Hour</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'hour_of_day') { echo 'selected="selected"'; } ?> value="hour_of_day">Hora do dia</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'day_of_week') { echo 'selected="selected"'; } ?> value="day_of_week">Dia da semana</option>
<option <?php if (empty($_REQUEST['group']) || $_REQUEST['group'] == 'day') { echo 'selected="selected"'; } ?> value="day">Dia</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'week') { echo 'selected="selected"'; } ?> value="week">Semana ( Dom-Sab )</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'month') { echo 'selected="selected"'; } ?> value="month">Mês</option>
</optgroup>
<optgroup label="Telephone Number">
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'clid') { echo 'selected="selected"'; } ?> value="clid">Caller*ID</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'src') { echo 'selected="selected"'; } ?> value="src">Origem</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'dst') { echo 'selected="selected"'; } ?> value="dst">Destino</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'did') { echo 'selected="selected"'; } ?> value="did">DID</option>
</optgroup>
<optgroup label="Tech info">
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'disposition') { echo 'selected="selected"'; } ?> value="disposition">Disposição</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'disposition_by_day') { echo 'selected="selected"'; } ?> value="disposition_by_day">Disposição por dia</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'disposition_by_hour') { echo 'selected="selected"'; } ?> value="disposition_by_hour">Disposição por hora</option>
<option <?php if (isset($_REQUEST['group']) && $_REQUEST['group'] == 'dcontext') { echo 'selected="selected"'; } ?> value="dcontext">Contexto de destino</option>
</optgroup>
</select></td><td align="left" width="40%">
</td></td></table>
</td>
</tr>
<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" value="Buscar" />
<input <?php if (empty($_REQUEST['search_mode']) || $_REQUEST['search_mode'] == 'all') { echo 'checked="checked"'; } ?> type="radio" name="search_mode" value="all" />: para todas as condições
<input <?php if (isset($_REQUEST['search_mode']) && $_REQUEST['search_mode'] == 'any') { echo 'checked="checked"'; } ?> type="radio" name="search_mode" value="any" />: para uma das condições
</td>
</tr>
</table>
</fieldset>
</form>
</td>
</tr>
</table>
<a id="CDR"></a>

