<?php

class SolderController extends BaseController {

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('auth');
	}

	public function getConfigure()
	{
		if (Input::get('edit-solder'))
		{
			Config::set('solder.mirror_url',Input::get('mirror_url'));
			Config::set('solder.repo_location',Input::get('repo_location'));
			Config::set('solder.platform_key',Input::get('platform_key'));
			return Redirect::to('solder/configure')
				->with('success','Your solder configuration has been updated.');
		}
		return View::make('solder.configure');
	}

	public function getCacheMinecraft() {
		if (Request::ajax())
		{
			$reason = '';
			try {
				$reason = MinecraftUtils::getMinecraftVersions();
			}
			catch (Exception $e) {
				return Response::json(array(
									'status' => 'error',
									'reason' => $e
									));
			}

			if (Cache::has('minecraftversions')){
				return Response::json(array(
									'status' => 'success',
									'reason' => $reason
									));
			} else {
				return Response::json(array(
									'status' => 'error',
									'reason' => 'An unknown error has occured.'
									));
			}
		}

		return App::abort(404);
	}

}