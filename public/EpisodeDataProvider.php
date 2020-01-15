<?php
/**
 * Service to provide episode data
 */
class EpisodeDataProvider{
    
    const CACHE_FILE_PATH = "../public/resources/episode-data.json";
    const CACHE_TTL       = 600;
    const API_ENDPOINT    = 'http://3ev.org/dev-test-api/';
    /** @var mixed */
    private $m_episodes = null;
    /** @var boolean */
    private $m_error    = false;
    /**
     * @return static
     */
    public static function create() {
        return new static();
    }
    /**
     * @return mixed[]|null The episode data unsorted or null.
     */
    public function getEpisodeData() {
        return $this->m_episodes;
    }
    /**
     * @return boolean Whether there was an error loading the episodes
     */
    public function getError() {
        return $this->m_error;
    }
    /**
     * Loads the episodes from the api endpoint
     * @return mixed[]
     */
    private function getEpisodesFromApi() {
        $client       = new GuzzleHttp\Client();
        $res          = $client->request('GET', self::API_ENDPOINT);
        $episode_data = $res->getBody();
        
        file_put_contents(self::CACHE_FILE_PATH,$episode_data);
        
        return json_decode($episode_data, true);       
    }
    /**
     * Loads episodes from the cache file
     * @param boolean $check_fresh Check whether the cache is still fresh
     * @return type
     */    
    private function loadFromCache($check_fresh = false) {
        if(false === file_exists(self::CACHE_FILE_PATH))
            return null;
        
        $last_modified_time = filemtime("../public/resources/episode-data.json");
        $now                = time();
        // if the cache is stale, don't return the contents.
        if($check_fresh && self::CACHE_TTL < ($now - $last_modified_time))
            return null;
            
        return json_decode(file_get_contents(self::CACHE_FILE_PATH),true);
    }
    /**
     * @return $this
     */        
    public function run() {
        try {
           $this->m_episodes = $this->loadFromCache(true);

           if(null === $this->m_episodes) {
                $this->m_episodes = $this->getEpisodesFromApi();
           }  
        } catch (Exception $ex) {
            // if there is an exception, attempt to load from cache, even if stale.
            $this->m_episodes = $this->loadFromCache();
            $this->m_error    = null === $this->m_episodes;
        }
      
        return $this;
    }
}
