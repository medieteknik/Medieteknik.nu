<?php
$search = array(
              'id'          => 'search',
              'name'        => 'search',
              'value'		=> (isset($query) ? $query : ''),
              'placeholder'	=> $lang['misc_search'],
              'maxlength'   => '100',
              'size'        => '50'
            );



echo form_open('admin/groups/add_member/'.$groups_year_id.'/'.$group_id.'/search');
echo '<div class="main-box clearfix">';

if(isset($status))
{
	if($status)
	{
		echo '<p class="notice">'.$lang['admin_addusers_success'].' '.anchor('admin/groups/edit_member/'.$groups_year_id.'/'.$group_id.'/'.$user_added, $lang['admin_edituser']).'</p>';
	}
	else{
		echo $status;
		echo '<p class="notice red"><strong>'.$lang['admin_addusers_error'].'</strong> ';
		echo '</p>';
	}
}

echo '<h2>'.$lang['admin_searchusers'].' '.anchor('admin/groups/list_members/'.$groups_year_id.'/'.$group_id, '&larr; '.$lang['misc_back']).'</h2>',
	form_input($search),
	form_submit('submit', $lang['misc_search']),
'</div><!-- close .main-box -->',
form_close();

if(isset($result) && is_array($result))
{
	$this->table->set_heading(array($lang['user_name'], $lang['user_lukasid'], ''));
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
		$user = array($user_name, $user->lukasid, anchor('admin/groups/add_member/'.$groups_year_id.'/'.$group_id.'/add/'.$user->id, '<i class="-icon-adduser"></i>', ' title="'.$lang['admin_addasmember'].'"'));
		$this->table->add_row($user);
	}

	echo '
	<div class="main-box clearfix profile">
		<h2>'.$lang['misc_searchresult'].' <em>'.$query.'</em> ('.sizeof($result).' '.$lang['misc_searchhits'].')</h2>';
		echo $this->table->generate();
	echo'</div><!-- close .main-box -->';
}

?>
