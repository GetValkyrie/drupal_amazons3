<?php

namespace Drupal\amazons3;

use Guzzle\Http\QueryString;
use Guzzle\Http\Url;

/**
 * Represents an s3:// stream URL.
 *
 * @class S3Url
 * @package Drupal\amazons3
 */
class S3Url extends Url {

  /**
   * Override __construct() to default scheme to s3.
   *
   * @param string $bucket
   *   The bucket to use for the URL.
   * @param string $key
   *   (optional) Key for the URL.
   */
  public function __construct($bucket, $key = null) {
    if ($key) {
      $key = '/' . $key;
    }

    parent::__construct('s3', $bucket, null, null, null, $key);
  }


  /**
   * Return the bucket associated with the URL.
   *
   * @return string
   */
  public function getBucket() {
    return $this->getHost();
  }

  /**
   * Set the bucket.
   *
   * @param string $bucket
   */
  public function setBucket($bucket) {
    $this->setHost($bucket);
  }

  /**
   * Return the S3 object key.
   *
   * @return string
   */
  public function getKey() {
    // Remove the leading slash getPath() keeps in the path.
    return substr($this->getPath(), 1);
  }

  /**
   * Set the S3 object key.
   *
   * This automatically prepends a slash to the path.
   *
   * @param string $key
   */
  public function setKey($key) {
    $this->setPath('/' . $key);
  }

  /**
   * Set the path part of the URL.
   *
   * Since we are using these URLs in a non-HTTP context, we don't replace
   * spaces or question marks.
   *
   * @param array|string $path Path string or array of path segments
   *
   * @return Url
   */
  public function setPath($path)
  {
    if (is_array($path)) {
      $path = '/' . implode('/', $path);
    }

    $this->path = $path;

    return $this;
  }

  /**
   * Return the image style URL associated with this URL.
   *
   * @param string $style_name
   *   The name of the image style.
   *
   * @return \Drupal\amazons3\S3Url
   *   An image style URL.
   */
  public function getImageStyleUrl($style_name) {
    $styleUrl = new S3Url($this->getBucket());
    $styleUrl->setPath("/styles/$style_name/" . $this->getKey());
    return $styleUrl;
  }

  /**
   * Overrides factory() to support bucket configs.
   *
   * @param string $url
   *   Full URL used to create a Url object
   * @param \Drupal\amazons3\StreamWrapperConfiguration $config
   *   (optional) Configuration to associate with this URL.
   *
   * @return static
   *   An S3Url.
   */
  public static function factory($url, StreamWrapperConfiguration $config = null) {
    !$config ? $bucket = null : $bucket = $config->getBucket();

    $defaults = array('scheme' => 's3', 'host' => $bucket, 'path' => null, 'port' => null, 'query' => null,
      'user' => null, 'pass' => null, 'fragment' => null);

    if (false === ($parts = parse_url($url))) {
      throw new \InvalidArgumentException('Was unable to parse malformed url: ' . $url);
    }

    $parts += $defaults;

    return new static($parts['host'], substr($parts['path'], 1));
  }

  /**
   * Generate a URL from a bucket and key.
   *
   * @param string $bucket
   *   The bucket the key is in.
   * @param string $key
   *   The key of the object.
   *
   * @return \Drupal\amazons3\S3Url
   *   A S3Url object.
   */
  public static function fromKey($bucket, $key) {
    $url = new S3Url($bucket);
    $url->setPath('/' . $key);
    return $url;
  }
}
