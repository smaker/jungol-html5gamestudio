<?php
class GSLoader
{
	public function __construct()
	{
		$uri = &load_class('URI', 'core');
		$model = &load_class('Model', 'core');

		$InstallModel = &load_class('installmodel', 'models', NULL);

		if((strtolower($uri->segment(1)) != 'install') && !$InstallModel->is_installed())
		{
			$load = &load_class('Loader', 'core');
			$load->helper('url');

			redirect('/install/', 302);
		}
	}
}