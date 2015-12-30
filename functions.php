<?php
	
	function encodeURL($unencoded_url) {
		$encoded_url = preg_replace_callback('#://([^/]+)/([^?]+)#', function ($match) {
			return '://' . $match[1] . '/' . join('/', array_map('rawurlencode', explode('/', $match[2])));
		}, $unencoded_url);
		return $encoded_url;
	}
			
    function recursiveScanDirectory($websiteRoot, $root, $path, $title, $language, $imagepath, $rating) {
        $content = array_diff(scandir($path), array('..', '.'));
        //print_r($content);
		$externalPath = encodeURL(str_replace($root, $websiteRoot, $path));

        // Reading poster file
        if (in_array('cover.jpg', $content)) {
            //print("Cover.jpg found!");
            $imagepath = $externalPath . '/cover.jpg';
        } else if (in_array('cover.png', $content)) {
            //print("Cover.png found!");
            $imagepath = $externalPath . '/cover.png';
        }
        // Reading eventual config file
        $coverfile = $path . '/cover.json';
        if (in_array('cover.json', $content)) {
            //print("Cover.json found!");
            $file = file_get_contents($coverfile);
            $coverdata = json_decode($file);

            if (isset($coverdata->title)) {
                $title = $coverdata->title;
            }
            if (isset($coverdata->image)) {
                $imagepath = $externalPath . "/" . $coverdata->image;
            }
            if (isset($coverdata->language)) {
                $language = $coverdata->language;
            }
            if (isset($coverdata->rating)) {
                $rating = $coverdata->rating;
            }
        }

        $films = array();
        $newdirs = array();
        // Scanning local files, looking for videos
        foreach ($content as $i => $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            // Check if it's a video file
            if ($ext === "mp4" || $ext === "mkv" || $ext === "avi" || $ext === "wmv") {
                $film = new stdClass;
                $film->filename = $file;
                $film->path = str_replace("\\","/",$externalPath."/".$file);
                $film->image = str_replace("\\","/",$imagepath);
                $film->title = $title;
                $film->language = $language;
                $film->rating = $rating;

                array_push($films, $film);
            } else if (is_dir($path."/".$file)) {
                array_push($newdirs, $file);
            }
        }
        // Scanning local directories
        foreach ($newdirs as $i => $folder) {
            $result = recursiveScanDirectory($websiteRoot, $root, $path."/".$folder, $title, $language, $imagepath, $rating);
            $films = array_merge($films, $result);
        }
        return $films;
    }

    function getFilmsJSON($websiteRoot, $root) {
        $films = recursiveScanDirectory($websiteRoot, $root, $root, "", "", "no_poster.svg", -1);
        return json_encode($films);
    }
?>
