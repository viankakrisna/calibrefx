<?php 

/**
 * Calibrefx Format Helper
 * 
 */

/**
 * Return a phrase shortened in length to a maximum number of characters.
 *
 * Result will be truncated at the last white space in the original
 * string. In this function the word separator is a single space ( ' ' ).
 * Other white space characters (like newlines and tabs) are ignored.
 *
 * If the first $max_characters of the string do contain a space
 * character, an empty string will be returned.
 *
 * @param string $phrase A string to be shortened.
 * @param integer $max_characters The maximum number of characters to return.
 * @return string
 */
function calibrefx_truncate_phrase( $phrase, $max_characters ) {
    // Inline styles/scripts
    $phrase = trim( preg_replace( '#<(s(cript|tyle) ).*?</\1>#si', '', $phrase ) );

    $phrase = trim( $phrase );

    if ( strlen( $phrase ) > $max_characters ) {

        // Truncate $phrase to $max_characters + 1
        $phrase = substr( $phrase, 0, $max_characters + 1 );

        // Truncate to the last space in the truncated string.
        $phrase = trim( substr( $phrase, 0, strrpos( $phrase, ' ' ) ) );
    }

    return $phrase;
}

/**
 * This function strips out tags and shortcodes,
 * limits the output to $max_char characters,
 * and appends an ellipses and more link to the end.
 */
function get_the_content_limit( $max_char, $more_link_text = '(more...)', $stripteaser = 0, $wrap_open='<p>', $wrap_close='</p>' ) {

    $content = get_the_content( '', $stripteaser );

    // Strip tags and shortcodes
    $content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

    // Truncate $content to $max_char
    $content = calibrefx_truncate_phrase( $content, $max_char );

    // More Link?
    $link = '';
    if ( $more_link_text ) {
        $link = apply_filters( 'get_the_content_more_link', sprintf( '%s <a href="%s" class="more-link">%s</a>', '&hellip;', get_permalink(), $more_link_text ), $more_link_text );
        $output = $wrap_open . sprintf( '%s %s', $content, $link ) . $wrap_close;
    } else {
        $output = $wrap_open . sprintf( '%s', $content ) . $wrap_close;
    }

    return apply_filters( 'get_the_content_limit', $output, $content, $link, $max_char );
}

/**
 * Helper function to limit the content
 * called get_the_content_limit function
 */
function the_content_limit( $max_char, $more_link_text = '(more...)', $stripteaser = 0 ) {

    $content = get_the_content_limit( $max_char, $more_link_text, $stripteaser );
    echo apply_filters( 'the_content_limit', $content );
}

/**
 * limits the output for title to $max_char characters,
 * and appends an ellipses to the end.
 */
function get_the_title_limit( $max_char, $post_id = 0 ) {
    $title = get_the_title( $post_id );

    // Truncate $content to $max_char
    
    if (strlen( $title) > $max_char ) {
        $title = calibrefx_truncate_phrase( $title, $max_char );
        $output = sprintf( '%s...', $title );
    } else {
        $output = sprintf( '%s', $title );
    }

    return apply_filters( 'get_the_title_limit', $output, $title, $max_char );
}

/**
 * Helper function to limit the title
 * called get_the_titl_limit function
 */
function the_title_limit( $max_char, $post_id = 0 ) {
    $title = get_the_title_limit( $max_char, $post_id );
    echo apply_filters( 'the_title_limit', $title );
}

/**
 * Calculate the time difference - a replacement for human_time_diff() until it
 * is improved.
 *
 * Based on BuddyPress function bp_core_time_since(), which in turn is based on
 * functions created by Dunstan Orchard - http://1976design.com
 *
 * This function will return an text representation of the time elapsed since a
 * given date, giving the two largest units e.g.:
 *  - 2 hours and 50 minutes
 *  - 4 days
 *  - 4 weeks and 6 days
 *
 * @since 1.7.0
 *
 * @param $older_date int Unix timestamp of date you want to calculate the time since for
 * @param $newer_date int Unix timestamp of date to compare older date to. Default false (current time)
 * @return str The time difference
 */
function calibrefx_human_time_diff( $older_date, $newer_date = false ) {

    /** If no newer date is given, assume now */
    $newer_date = $newer_date ? $newer_date : time();

    /** Difference in seconds */
    $since = absint( $newer_date - $older_date );

    if (!$since){
        return '0 ' . _x( 'seconds', 'time difference', 'calibrefx' );
    }

    /** Hold units of time in seconds, and their pluralised strings (not translated yet) */
    $units = array(
        array( 31536000, _nx_noop( '%s year', '%s years', 'time difference' ) ), // 60 * 60 * 24 * 365
        array( 2592000, _nx_noop( '%s month', '%s months', 'time difference' ) ), // 60 * 60 * 24 * 30
        array( 604800, _nx_noop( '%s week', '%s weeks', 'time difference' ) ), // 60 * 60 * 24 * 7
        array( 86400, _nx_noop( '%s day', '%s days', 'time difference' ) ), // 60 * 60 * 24
        array( 3600, _nx_noop( '%s hour', '%s hours', 'time difference' ) ), // 60 * 60
        array( 60, _nx_noop( '%s minute', '%s minutes', 'time difference' ) ),
        array( 1, _nx_noop( '%s second', '%s seconds', 'time difference' ) ),
    );

    /** Step one: the first unit */
    for ( $i = 0, $j = count( $units ); $i < $j; $i++ ) {
        $seconds = $units[$i][0];

        /** Finding the biggest chunk (if the chunk fits, break) */
        if ( ( $count = floor( $since / $seconds ) ) != 0 ){
            break;
        }
    }

    /** Translate unit string, and add to the output */
    $output = sprintf( translate_nooped_plural( $units[$i][1], $count, 'calibrefx' ), $count );

    /** Note the next unit */
    $ii = $i + 1;

    /** Step two: the second unit */
    if ( $ii <= $j ) {
        $seconds2 = $units[$ii][0];

        /** Check if this second unit has a value > 0 */
        if ( ( $count2 = floor( ( $since - ( $seconds * $count ) ) / $seconds2) ) != 0 ) {
            $output .= sprintf( ' %s ' . translate_nooped_plural( $units[$ii][1], $count2, 'calibrefx' ), _x( 'and', 'separator in time difference', 'calibrefx' ), $count2);
        }
    }

    return $output;
}

/**
 * Return time with a format: (time) ago
 *
 * @param $date A date to be formatted
 */
function calibrefx_time_ago( $date ) {
    if ( empty( $date) ) {
        return "No date provided";
    }
 
    $periods = array( "second", "minute", "hour", "day", "week", "month", "year", "decade" );
 
    $lengths = array( "60", "60", "24", "7", "4.35", "12", "10" );
 
    $now = time();
 
    $unix_date = strtotime( $date );
 
    // check validity of date
 
    if( empty( $unix_date ) ) {
        return "Bad date";
    }
 
    // is it future date or past date
    if ( $now > $unix_date ) {
        $difference = $now - $unix_date;
        $tense = "ago";
    } else {
        $difference = $unix_date - $now;
        $tense = "from now";
    }
 
    for ( $j = 0; $difference >= $lengths[$j] && $j < count( $lengths)-1; $j++ ) {
        $difference /= $lengths[$j];
    }
 
    $difference = round( $difference );
 
    if( $difference != 1 ) {
        $periods[$j].= "s";
    }
 
    return "$difference $periods[$j] {$tense}";
}

/**
 * Returns an array of allowed tags for output formatting.
 */
function calibrefx_formatting_allowedtags() {

    return apply_filters(
                'calibrefx_formatting_allowedtags', 
                array(
                    'a'          => array( 'href' => array(), 'title' => array(),),
                    'b'          => array(),
                    'blockquote' => array(),
                    'br'         => array(),
                    'div'        => array( 
                                        'align' => array(), 
                                        'class' => array(), 
                                        'style' => array(),
                                    ),
                    'em'         => array(),
                    'i'          => array(),
                    'p'          => array( 'align' => array(), 'class' => array(), 'style' => array(),),
                    'span'       => array( 'align' => array(), 'class' => array(), 'style' => array(),),
                    'strong'     => array(),
                )
    );
}

/**
 * Helper function for wp_kses() that can be used as a filter function.
 */
function calibrefx_formatting_kses( $string ) {
    return wp_kses( $string, calibrefx_formatting_allowedtags() );
}

/**
 * Adds links to the contents of a tweet.
 */
function calibrefx_tweet_linkify( $text ) {

    $text = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", '\\1<a href="\\2" target="_blank">\\2</a>', $text);
    $text = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", '\\1<a href="http://\\2" target="_blank">\\2</a>', $text);
    $text = preg_replace( '/@(\w+)/', '<a href="http://www.twitter.com/\\1" target="_blank">@\\1</a>', $text);
    $text = preg_replace( '/#(\w+)/', '<a href="http://search.twitter.com/search?q=\\1" target="_blank">#\\1</a>', $text);

    return $text;
}

/**
 * Search value in array recursively
 */
function array_r( $needle, $haystack, $strict=true, $path=array() )
{
    if ( !is_array( $haystack ) ) {
        return false;
    }

    foreach( $haystack as $key => $val ) {
        if( is_array( $val ) && $subPath = array_r( $needle, $val, $strict, $path ) ) {
            $path = array_merge( $path, array( $key), $subPath );
            return $path;
        } elseif( ( !$strict && $val == $needle ) || ( $strict && $val === $needle ) ) {
            $path[] = $key;
            return $path;
        }
    }
    return false;
}

/**
 * Convert CSV file to Array with key values
 */
if( !function_exists( 'csv_to_array' ) ) {
    function csv_to_array( $csvfile, $delimiter = ',' ) {

        if( !file_exists( $csvfile ) ) {
            return false;
        }

        $handle = fopen( $csvfile, "r" );

        $header = NULL;
        $data = array();
        while ( ( $row = fgetcsv( $handle, 1000, "," ) ) !== FALSE ) {
            if( !$header ){
                $header = $row;
            } else {
                $data[] = array_combine( $header, $row );
            }
        }

        fclose( $handle );

        return $data;
    }
}