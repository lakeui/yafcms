<?php

namespace AlibabaCloud\Videoenhan\V20200320;

use AlibabaCloud\Client\Resolver\ApiResolver;

/**
 * @method AbstractEcommerceVideo abstractEcommerceVideo(array $options = [])
 * @method AbstractFilmVideo abstractFilmVideo(array $options = [])
 * @method AdjustVideoColor adjustVideoColor(array $options = [])
 * @method EraseVideoLogo eraseVideoLogo(array $options = [])
 * @method EraseVideoSubtitles eraseVideoSubtitles(array $options = [])
 * @method GenerateVideo generateVideo(array $options = [])
 * @method GetAsyncJobResult getAsyncJobResult(array $options = [])
 * @method SuperResolveVideo superResolveVideo(array $options = [])
 */
class VideoenhanApiResolver extends ApiResolver
{
}

class Rpc extends \AlibabaCloud\Client\Resolver\Rpc
{
    /** @var string */
    public $product = 'videoenhan';

    /** @var string */
    public $version = '2020-03-20';

    /** @var string */
    public $method = 'POST';

    /** @var string */
    public $serviceCode = 'videoenhan';
}

/**
 * @method string getDuration()
 * @method string getAsync()
 * @method string getVideoUrl()
 * @method string getWidth()
 * @method string getHeight()
 */
class AbstractEcommerceVideo extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withDuration($value)
    {
        $this->data['Duration'] = $value;
        $this->options['form_params']['Duration'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAsync($value)
    {
        $this->data['Async'] = $value;
        $this->options['form_params']['Async'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withVideoUrl($value)
    {
        $this->data['VideoUrl'] = $value;
        $this->options['form_params']['VideoUrl'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withWidth($value)
    {
        $this->data['Width'] = $value;
        $this->options['form_params']['Width'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withHeight($value)
    {
        $this->data['Height'] = $value;
        $this->options['form_params']['Height'] = $value;

        return $this;
    }
}

/**
 * @method string getLength()
 * @method string getAsync()
 * @method string getVideoUrl()
 */
class AbstractFilmVideo extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withLength($value)
    {
        $this->data['Length'] = $value;
        $this->options['form_params']['Length'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAsync($value)
    {
        $this->data['Async'] = $value;
        $this->options['form_params']['Async'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withVideoUrl($value)
    {
        $this->data['VideoUrl'] = $value;
        $this->options['form_params']['VideoUrl'] = $value;

        return $this;
    }
}

/**
 * @method string getMode()
 * @method string getAsync()
 * @method string getVideoUrl()
 * @method string getVideoBitrate()
 * @method string getVideoCodec()
 * @method string getVideoFormat()
 */
class AdjustVideoColor extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withMode($value)
    {
        $this->data['Mode'] = $value;
        $this->options['form_params']['Mode'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAsync($value)
    {
        $this->data['Async'] = $value;
        $this->options['form_params']['Async'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withVideoUrl($value)
    {
        $this->data['VideoUrl'] = $value;
        $this->options['form_params']['VideoUrl'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withVideoBitrate($value)
    {
        $this->data['VideoBitrate'] = $value;
        $this->options['form_params']['VideoBitrate'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withVideoCodec($value)
    {
        $this->data['VideoCodec'] = $value;
        $this->options['form_params']['VideoCodec'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withVideoFormat($value)
    {
        $this->data['VideoFormat'] = $value;
        $this->options['form_params']['VideoFormat'] = $value;

        return $this;
    }
}

/**
 * @method array getBoxes()
 * @method string getAsync()
 * @method string getVideoUrl()
 */
class EraseVideoLogo extends Rpc
{

    /**
     * @param array $boxes
     *
     * @return $this
     */
	public function withBoxes(array $boxes)
	{
	    $this->data['Boxes'] = $boxes;
		foreach ($boxes as $depth1 => $depth1Value) {
			if(isset($depth1Value['W'])){
				$this->options['form_params']['Boxes.' . ($depth1 + 1) . '.W'] = $depth1Value['W'];
			}
			if(isset($depth1Value['H'])){
				$this->options['form_params']['Boxes.' . ($depth1 + 1) . '.H'] = $depth1Value['H'];
			}
			if(isset($depth1Value['X'])){
				$this->options['form_params']['Boxes.' . ($depth1 + 1) . '.X'] = $depth1Value['X'];
			}
			if(isset($depth1Value['Y'])){
				$this->options['form_params']['Boxes.' . ($depth1 + 1) . '.Y'] = $depth1Value['Y'];
			}
		}

		return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAsync($value)
    {
        $this->data['Async'] = $value;
        $this->options['form_params']['Async'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withVideoUrl($value)
    {
        $this->data['VideoUrl'] = $value;
        $this->options['form_params']['VideoUrl'] = $value;

        return $this;
    }
}

/**
 * @method string getBH()
 * @method string getAsync()
 * @method string getVideoUrl()
 * @method string getBW()
 * @method string getBX()
 * @method string getBY()
 */
class EraseVideoSubtitles extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withBH($value)
    {
        $this->data['BH'] = $value;
        $this->options['form_params']['BH'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAsync($value)
    {
        $this->data['Async'] = $value;
        $this->options['form_params']['Async'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withVideoUrl($value)
    {
        $this->data['VideoUrl'] = $value;
        $this->options['form_params']['VideoUrl'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withBW($value)
    {
        $this->data['BW'] = $value;
        $this->options['form_params']['BW'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withBX($value)
    {
        $this->data['BX'] = $value;
        $this->options['form_params']['BX'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withBY($value)
    {
        $this->data['BY'] = $value;
        $this->options['form_params']['BY'] = $value;

        return $this;
    }
}

/**
 * @method string getTransitionStyle()
 * @method string getScene()
 * @method string getDuration()
 * @method string getPuzzleEffect()
 * @method string getHeight()
 * @method string getDurationAdaption()
 * @method array getFileList()
 * @method string getMute()
 * @method string getAsync()
 * @method string getSmartEffect()
 * @method string getWidth()
 * @method string getStyle()
 */
class GenerateVideo extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withTransitionStyle($value)
    {
        $this->data['TransitionStyle'] = $value;
        $this->options['form_params']['TransitionStyle'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withScene($value)
    {
        $this->data['Scene'] = $value;
        $this->options['form_params']['Scene'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withDuration($value)
    {
        $this->data['Duration'] = $value;
        $this->options['form_params']['Duration'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPuzzleEffect($value)
    {
        $this->data['PuzzleEffect'] = $value;
        $this->options['form_params']['PuzzleEffect'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withHeight($value)
    {
        $this->data['Height'] = $value;
        $this->options['form_params']['Height'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withDurationAdaption($value)
    {
        $this->data['DurationAdaption'] = $value;
        $this->options['form_params']['DurationAdaption'] = $value;

        return $this;
    }

    /**
     * @param array $fileList
     *
     * @return $this
     */
	public function withFileList(array $fileList)
	{
	    $this->data['FileList'] = $fileList;
		foreach ($fileList as $depth1 => $depth1Value) {
			if(isset($depth1Value['FileName'])){
				$this->options['form_params']['FileList.' . ($depth1 + 1) . '.FileName'] = $depth1Value['FileName'];
			}
			if(isset($depth1Value['FileUrl'])){
				$this->options['form_params']['FileList.' . ($depth1 + 1) . '.FileUrl'] = $depth1Value['FileUrl'];
			}
			if(isset($depth1Value['Type'])){
				$this->options['form_params']['FileList.' . ($depth1 + 1) . '.Type'] = $depth1Value['Type'];
			}
		}

		return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withMute($value)
    {
        $this->data['Mute'] = $value;
        $this->options['form_params']['Mute'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAsync($value)
    {
        $this->data['Async'] = $value;
        $this->options['form_params']['Async'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSmartEffect($value)
    {
        $this->data['SmartEffect'] = $value;
        $this->options['form_params']['SmartEffect'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withWidth($value)
    {
        $this->data['Width'] = $value;
        $this->options['form_params']['Width'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withStyle($value)
    {
        $this->data['Style'] = $value;
        $this->options['form_params']['Style'] = $value;

        return $this;
    }
}

/**
 * @method string getAsync()
 * @method string getJobId()
 */
class GetAsyncJobResult extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAsync($value)
    {
        $this->data['Async'] = $value;
        $this->options['form_params']['Async'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withJobId($value)
    {
        $this->data['JobId'] = $value;
        $this->options['form_params']['JobId'] = $value;

        return $this;
    }
}

/**
 * @method string getBitRate()
 * @method string getAsync()
 * @method string getVideoUrl()
 */
class SuperResolveVideo extends Rpc
{

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withBitRate($value)
    {
        $this->data['BitRate'] = $value;
        $this->options['form_params']['BitRate'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAsync($value)
    {
        $this->data['Async'] = $value;
        $this->options['form_params']['Async'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withVideoUrl($value)
    {
        $this->data['VideoUrl'] = $value;
        $this->options['form_params']['VideoUrl'] = $value;

        return $this;
    }
}
