<?php

//  no direct access 
if( !defined('ABSPATH') ) : exit(); endif;

// shortcode function
function yt_embed_function($attr) {

    $args = shortcode_atts(array(

        'keyword' => '',
        'title' => 'Related Videos',
        'count' => 5,
        'iframe_width' => 560,
        'iframe_height' => 315,

    ), $attr);

    // initializing 
    $api_key = '';
    $output_HTML = '';

    try{

        $youtube_embed_shortcode_api_key = get_option(YOUTUBE_EMBED_SHORTCODE_PLUGIN_NAME . '_api_key');

        // Search for videos
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' . urlencode($args['keyword']) . '&type=video&maxResults=' . (int)($args['count']) . '&key=' . $youtube_embed_shortcode_api_key,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);



    } catch (PDOException $e) {

        $output_HTML .= '<div class="alert alert-danger" role="alert">
            '.esc_html("Error: ".$e->getMessage()).'
        </div>';

        return true;
        
    } finally{

        $search_results = json_decode($response, true);

        if (isset($search_results['items'])){
    
            if(count($search_results['items']) > 0){
    
                // loading bootstrap css
                // echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';
    
                // loading jquery
                echo '<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>';
    
                // Get the first video
                $first_video = $search_results['items'][0];
                $first_video_id = $first_video['id']['videoId'];
    
                // Generate the output HTML
                $output_HTML .= '<div class="yt-embed">';
                
                $output_HTML .= '<iframe id="youtube_main_iframe" width="'.$args['iframe_width'].'" height="'.$args['iframe_height'].'" src="https://www.youtube.com/embed/' . $first_video_id . '" frameborder="0" allowfullscreen></iframe>';
    
                if ($args['count'] > 0) {
                    $output_HTML .= '<h3>' . esc_html($args['title']) . '</h3>';
                    $output_HTML .= '<ul id="yt_search_results_ul" class="yt-embed-related">';
    
                    foreach ($search_results['items'] as $video) {
                        $video_id = $video['id']['videoId'];
                        $video_title = $video['snippet']['title'];
                        $video_thumbnail = $video['snippet']['thumbnails']['default']['url'];
                        $video_description = $video['snippet']['description'];
    
                        $output_HTML .= '<li><a href="https://www.youtube.com/embed/' . $video_id . '" target="_blank"><strong>' . esc_html($video_title) . '</strong><br><img src="' . $video_thumbnail . '" alt="' . esc_attr($video_title) . '"></a><br>' . esc_html($video_description) . '</li>';
                    }
    
                    $output_HTML .= '</ul>';
                }
    
                $output_HTML .= '</div>';
    
    
                echo '<script>
            
                    $( document ).ready(function() {
            
                        $("#yt_search_results_ul li a").click(function(e){
                            e.preventDefault();

                            $("#youtube_main_iframe").attr("src", $(this).attr("href"));
                            $("html, body").animate({
                                scrollTop: $("#youtube_main_iframe").offset().top
                            }, 1000);

                        })
                    
                    });
        
                </script>';
    
            }else{
    
                $output_HTML .= '<div class="alert alert-danger" role="alert">
                    '.esc_html("No Results Found!").'
                </div>';
        
            }
    
        }else{
    
            $output_HTML .= '<div class="alert alert-danger" role="alert">
                '.esc_html("No Results Found!").'
            </div>';
    
        }


    }


    return $output_HTML;

}