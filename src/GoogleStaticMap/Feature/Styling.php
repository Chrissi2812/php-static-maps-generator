<?php
namespace GoogleStaticMap\Feature;

/**
 * @author Ben Squire <b.squire@gmail.com>
 * @license Apache 2.0
 *
 * @package GoogleStaticMap
 *
 * @abstract This class abstracts the map feature styling part of the Google
 * Static map API. i.e: Determine the styling of the map features (Think map color,
 * opacity, build colors etc)
 *
 * @see https://github.com/bensquire/php-static-maps-generator
 */
class Styling
{
    public const SEPARATOR = '|';

    protected $gamma = null;
    protected $lightness = null;
    protected $saturation = null;
    protected $hue = null;
    protected $visibility = 'on';
    protected $invertLightness = false;
    protected $validVisibleModes = ['on', 'off', 'simplified'];

    /**
     * Sets the gamma value of the elements styling
     *
     * @param $gamma
     * @return $this
     * @throws \Exception
     */
    public function setGamma(float $gamma)
    {
        if ($gamma < 0.01 || $gamma > 10.0) {
            throw new \Exception('Invalid Gamma Styling Paramater Passed ' . $gamma);
        }

        $this->gamma = $gamma;
        return $this;
    }

    /**
     * Sets the lightness value of the elements styling
     *
     * @param $lightness
     * @return $this
     * @throws \Exception
     */
    public function setLightness(int $lightness)
    {
        if ($lightness > 100 || $lightness < -100) {
            throw new \Exception('Invalid Lightness Styling Paramater Passed ' . $lightness);
        }

        $this->lightness = $lightness;
        return $this;
    }

    /**
     * Sets the saturation of the elements styling
     *
     * @param $saturation
     * @return $this
     * @throws \Exception
     */
    public function setSaturation(int $saturation)
    {
        if ($saturation > 100 || $saturation < -100) {
            throw new \Exception('Invalid Saturation Styling Parameter Passed ' . $saturation);
        }

        $this->saturation = $saturation;
        return $this;
    }

    /**
     * Sets the RGB colour of the elements styling. Note: it is used for colour only, not lightness or saturation.
     *
     * @param $hue
     * @return $this
     * @throws \Exception
     */
    public function setHue(string $hue)
    {
        $hue = ltrim($hue, '#');

        if (!preg_match('/^[0-9A-Fa-f]{3,6}/', $hue)) {
            throw new \Exception('Invalid Hue (RGB) format: ' . $hue);
        }

        $this->hue = $hue;
        return $this;
    }

    /**
     * Invert the lightness of the elements styling.
     *
     * @param $invertLightness
     * @return $this
     */
    public function setInvertLightness(bool $invertLightness)
    {
        $this->invertLightness = ($invertLightness === true);
        return $this;
    }

    /**
     * Determines if an element should be visible, or simplified (complexity decided by google).
     *
     * @param string $visibility
     * @return $this
     * @throws \Exception
     */
    public function setVisibility(string $visibility)
    {
        if (!in_array($visibility, $this->validVisibleModes, true)) {
            throw new \Exception('Must be one of ' . implode($this->validVisibleModes, ', ') . '.');
        }

        $this->visibility = $visibility;
        return $this;
    }

    /**
     * Returns the elements gamma value
     *
     * @return float
     */
    public function getGamma(): float
    {
        return $this->gamma;
    }

    /**
     * Returns the elements lightness value
     *
     * @return int
     */
    public function getLightness(): int
    {
        return $this->lightness;
    }

    /**
     * Returns the elements saturation value
     *
     * @return int
     */
    public function getSaturation(): int
    {
        return $this->saturation;
    }

    /**
     * Returns the elements hue value
     *
     * @return string
     */
    public function getHue(): string
    {
        return $this->hue;
    }

    /**
     * Returns whether the lightness is inverted
     *
     * @return boolean
     */
    public function getInvertLightness(): bool
    {
        return $this->invertLightness;
    }

    /**
     * @return string
     */
    public function getVisible(): string
    {
        return $this->visibility;
    }

    /**
     * Builds the string for this specific elements styling
     *
     * @return string
     */
    public function build(): string
    {
        $url = [];

        if (!empty($this->gamma)) {
            $url[] = 'gamma:' . $this->gamma;
        }

        if (!empty($this->lightness)) {
            $url[] = 'lightness:' . $this->lightness;
        }

        if (!empty($this->saturation)) {
            $url[] = 'saturation:' . $this->saturation;
        }

        if (!empty($this->hue)) {
            $url[] = 'hue:0x' . $this->hue;
        }

        $url[] = 'visibility:' . ($this->visibility);
        $url[] = 'invert_lightness:' . ($this->invertLightness ? 'true' : 'false');

        return implode($this::SEPARATOR, $url);
    }
}
