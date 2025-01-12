<?php

namespace App\Services;

use GuzzleHttp\Client;

class Convertor
{

	protected $links;
	protected $target;
	protected $config;

	public function __construct(string $string, string $target = "clash", string $config = "")
	{

		$this->target = $target;
		$this->config = $config;
		preg_match_all('/\b[a-z0-9]+:\/\/[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|\/))/i', $string, $match);

		$this->links = $match[0];
	}

	public function mergeLinks(array $links): string
	{
		$text = implode("|", $links);
		return $text;
	}

	public function convert()
	{
		$client = new Client([
			'base_uri' => 'http://convertor:25500',
			'decode_content' => false,
			'headers' => [
				'Content-Type'  => 'application/json',
			]
		]);

		$links = $this->mergeLinks($this->links);

		$result = $client->get('/sub', [
			'query' => [
				'target' => $this->target,
				'url' => $links,
				'config' => "config/iran_base.ini",
			],
		]);

		$target = $result->getBody();
		if(!is_dir(dirname(__DIR__, 2) . "/dest")){
			mkdir(
				dirname(__DIR__, 2) . "/dest",
				0755
			);
		}
		$myfile = fopen(dirname(__DIR__, 2) . "/dest/config.yaml", "w") or die("Unable to open file!");
		fwrite($myfile, $target);
		fclose($myfile);
		return "/dest/config.yaml";
	}

	public function getLinks()
	{

		return $this->links;
	}
}
