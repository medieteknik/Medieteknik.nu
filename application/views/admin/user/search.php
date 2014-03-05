<?php
$search = array(
              'id'          => 'search',
              'name'        => 'search',
              'value'		=> (isset($query) ? $query : ''),
              'placeholder'	=> 'Sök',
              'maxlength'   => '100',
              'size'        => '50'
            );

echo form_open('admin_user/user_search/run'),'
<div class="main-box clearfix">
	<h2>'.$lang['admin_searchusers'].'</h2>',
	form_input($search),
	form_submit('submit', $lang['misc_search']),
'</div><!-- close .main-box -->',
form_close();

if(isset($result) && is_array($result))
{
	$this->table->set_heading(array($lang['user_userid'], $lang['user_lukasid'], $lang['user_name'], ''));
	$this->table->set_empty("&nbsp;");

	foreach ($result as $user)
	{
		// if user is disabled, tell the visitor
		if($user->disabled)
			$user_name = get_full_name($user).'
			<span class="smallnotice red" title="'.$lang['user_disabled_exp'].'">'.$lang['user_disabled'].'</span>';
		else
			$user_name = get_full_name($user);

		// add user row to table
		$user = array($user->id, $user->lukasid, $user_name, anchor('admin/user/edit_user/'.$user->id, '<i class="-icon-pen"></i>', ' title="'.$lang['admin_edituser'].'"'));
		$this->table->add_row($user);
	}

	echo '
	<div class="main-box clearfix profile">
		<h2>'.$lang['misc_searchresult'].' <em>'.$query.'</em> ('.sizeof($result).' '.$lang['misc_searchhits'].')</h2>';
		echo $this->table->generate();
	echo'</div><!-- close .main-box -->';
}

?>
