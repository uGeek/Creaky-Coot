<?php

	$language = $config['language'];
	if (isset($_POST['action']) && $_POST['action'] == 'edit') {
		$settings = new Settings();
		$ans = $settings->changes($_POST);
		if (!empty($ans)) {
			foreach ($ans as $v) {
				$this->addAlert(Trad::$settings[$v]);
			}
		}
		else {
			$this->addAlert(Trad::A_SUCCESS_SETTINGS, 'alert-success');
			if ($config['language'] != $language) {
				$_SESSION['alert'] = array(
					'text' => Trad::A_SUCCESS_SETTINGS,
					'type' => 'alert-success'
				);
				header('Location: '.Url::parse('settings'));
				exit;
			}
		}
	}

	$title = Trad::T_SETTINGS;

	$url_add = new Url('add', array(
		'url' => 'URL',
		'title' => 'TITLE'
	));
	$url_add = str_replace(
		array('URL', 'TITLE'),
		array('\'+encodeURIComponent(url)+\'', '\'+encodeURIComponent(title)+\''),
		$url_add->get()
	);
	$js = 'javascript:(function(){'
		.'var%20url%20=%20location.href;'
		.'var%20title%20=%20document.title%20||%20url;'
		.'window.open('
			.'\''.$url_add.'\','
			.'\'_blank\','
			.'\'menubar=no,height=440,width=424,toolbar=no,'
				.'scrollbars=no,status=no,dialog=1\''
		.');'
	.'})();';

	$auto_tag = ($config['auto_tag']) ? 'true' : 'false';
	$open_new_tab = ($config['open_new_tab']) ? 'true' : 'false';
	$languages = array();
	foreach (explode(',', LANGUAGES) as $v) {
		$languages[$v] = $v;
	}

	$content = '

<form action="'.Url::parse('settings').'" method="post">

	<h2>'.Trad::T_GLOBAL_SETTINGS.'</h2>

	<label for="title">'.Trad::F_TITLE.'</label>
	<input type="text" name="title" id="title" value="'
		.Text::chars($config['title']).'" />
	<label for="url">'.Trad::F_URL.'</label>
	<input type="url" name="url" id="url" value="'
		.Text::chars($config['url']).'" />
	<label for="url_rewriting">'.Trad::F_URL_REWRITING.'</label>
	<input type="text" name="url_rewriting" id="url_rewriting" value="'
		.(($config['url_rewriting']) ? $config['url_rewriting'] : '').'" />
	<p class="p-tip">'.Trad::F_TIP_URL_REWRITING.'</p>
	<label for="language">'.Trad::F_LANGUAGE.'</label>
	<select id="language" name="language">
		'.Text::options($languages, $config['language']).'
	</select>

	<p>&nbsp;</p>
	<h2>'.Trad::T_ARTICLES_SETTINGS.'</h2>

	<p><a href="'.$js.'" '.Text::click('js_add').'>'.Trad::S_ADD_POPUP.'</a>
		<textarea id="js_add" style="display:none">'.Text::chars($js).'</textarea>
	</p>

	<p>&nbsp;</p>

	<label for="links_per_page">'.Trad::F_LINKS_PER_PAGE.'</label>
	<input type="text" name="links_per_page" id="links_per_page" value="'
		.$config['links_per_page'].'" />
	<label for="auto_tag">'.Trad::F_AUTO_TAG.'</label>
	<select name="auto_tag" id="auto_tag">'.Text::options(
		array('true' => Trad::W_ENABLED, 'false' => Trad::W_DISABLED),
		$auto_tag
	).'</select>
	<p class="p-tip">'.Trad::F_TIP_AUTO_TAG.'</p>
	<label for="open_new_tab">'.Trad::F_OPEN_NEW_TAB.'</label>
	<select name="open_new_tab" id="open_new_tab">'.Text::options(
		array('true' => Trad::W_ENABLED, 'false' => Trad::W_DISABLED),
		$open_new_tab
	).'</select>
	<p class="p-tip">'.Trad::F_TIP_OPEN_NEW_TAB.'</p>

	<p>&nbsp;</p>
	<h2>'.Trad::T_USER_SETTINGS.'</h2>

	<label for="login">'.Trad::F_USERNAME.'</label>
	<input type="text" name="login" id="login" value="'
		.Text::chars($config['user']['login'])
	.'" />
	<label for="password">'.Trad::F_PASSWORD.'</label>
	<input type="password" name="password" id="password" />
	<p class="p-tip">'.Trad::F_TIP_PASSWORD.'</p>

	<p class="p-submit"><input type="submit" value="'.Trad::V_SAVE.'" /></p>
	<input type="hidden" name="action" value="edit" />
</form>

	';


?>