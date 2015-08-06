<?php

class FacebookImport {

    private $_url;

    public function __construct($url = '') {
        $path = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
        require_once( $path . '/wp-load.php' );
        
        if(!empty($url)) {
            $this->setUrl($url);
        }
    }

    /**
     * Function to set the URL to fetch data from
     * @param string $url
     * @return \FacebookImport
     * @throws Exception
     */
    public function setUrl($url) {
        if (empty($url) || !(filter_var($url, FILTER_VALIDATE_URL))) {
            throw new Exception('Url is not valid', 'URL_INVALID');
        }
        $this->_url = $url;
        return $this;
    }

    /**
     * Function to fetch data from a URL
     * @param string $url
     * @return mixed
     * @throws Exception
     */
    public function fetchData($url) {
        if (!function_exists('curl_init')) {
            throw new Exception('Curl is not installed on your server.', 'CURL_NOT_INSTALLED');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * Function to import data from the json url into db
     * @return FacebookImport
     * @throws Exception
     */
    public function importData() {
        $json = $this->fetchData($this->_url);
        $obj = json_decode($json);

        if (isset($obj->data)) {
            if (is_array($obj->data)) {
                foreach ($obj->data as $data) {
                    $postId = $this->insertPost($data);
                    $this->insertComments($data, $postId);
                }
            } else {
                $postId = $this->insertPost($data);
                $this->insertComments($data, $postId);
            }
            return $this;
        } else {
            throw new Exception('data object missing!', 'DATA_MISSING');
        }
    }

    /**
     * Function to insert a single post in the databse
     * @param object $data
     * @return integer
     */
    public function insertPost($data) {
        $timestamp = strtotime($data->created_time);

        $postArr = array(
            'post_content' => $data->message,
            'post_name' => sanitize_title($data->name),
            'post_title' => $data->name,
            'post_status' => 'private',
            'post_type' => 'facebook_post',
            'ping_status' => 'closed',
            'post_parent' => 0, // Sets the parent of the new post, if any. Default 0.
            'post_date' => date('Y-m-d H:i:s', $timestamp),
            'post_date_gmt' => gmdate('Y-m-d H:i:s', $timestamp),
            'comment_status' => 'closed',
        );


        $postId = wp_insert_post($postArr, $error);
        if ($postId) {
            // insert post meta
            add_post_meta($postId, '_fi_type', $data->type);
            add_post_meta($postId, '_fi_status_type', $data->status_type);
            add_post_meta($postId, '_fi_picture', $data->picture);
            add_post_meta($postId, '_fi_link', $data->link);
            add_post_meta($postId, '_fi_source_category', $data->from->category);
            add_post_meta($postId, '_fi_source_name', $data->from->name);
            add_post_meta($postId, '_fi_caption', $data->caption);
        }
        
        return $postId;
    }

    /**
     * Function to insert one or more comments for a post
     * @param object $data
     * @param integer $postId
     */
    public function insertComments($data, $postId) {

        if (isset($data->comments->data)) {
            $commentIds = array();
            if (is_array($data->comments->data)) {
                foreach ($data->comments->data as $comment) {
                    $commentIds[] = $this->insertComment($comment, $postId);
                }
            } else {
                return $this->insertComment($comment, $postId);
            }
            return $commentIds;
        }
    }
    
    /**
     * Function to insert a single comment for a post
     * @param object $comment
     * @param integer $postId
     * @return integer
     */
    public function insertComment($comment, $postId) {
        $commentArr = array(
            'comment_post_ID' => $postId,
            'comment_author' => $comment->from->name,
            'comment_content' => $comment->message,
            'comment_date' => date('Y-m-d H:i:s', strtotime($comment->created_time)),
            'comment_approved' => 1,
        );

        return wp_insert_comment($commentArr);
    }

}
