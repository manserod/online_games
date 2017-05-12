<?php
namespace Zankyou;

class Core
{
    /**
     * @param string[] $dictionary
     * @param string $start
     * @param string $end
     *
     * @return int|null
     */
    public function getSolution(array $dictionary, $origin, $end)
    {

        // first, we get an associative array:
        //   $key:   single word
        //   $value: array with all word with only 1 diference
        $schema = $this->prepare( $dictionary );

        $path[$origin] = [$origin];
        $words[] = $origin;

        while ( $words ) {

            $currentWord = current( $words );
            $currentPath = $path[$currentWord];

            if ( $end == $currentWord ) {

                return $currentPath;
            }

            if ( !isset($schema[$currentWord]) ) {
                return false;
            }

            foreach ( $schema[$currentWord] as $nextWord ) {

                if ( array_key_exists( $nextWord, $path ) ) {
                    continue;
                }

                $words[] = $nextWord;
                $path[$nextWord] = array_merge( $currentPath, [$nextWord] );

            }

            next( $words );
        }

    }

    /**
     * @param string[] $dictionary
     *
     * @return array
     */
    public function prepare(array $dictionary)
    {
        $dictionary = array_map( 'str_split', $dictionary );

        $result = [];
        foreach ( $dictionary as $word ) {
            foreach ( $dictionary as $auxWord ) {
                if ( 1 === count( array_diff_assoc( $word, $auxWord ) ) ) {

                    $result[implode( '', $word )][] = implode( '', $auxWord );
                }
            }
        }

        return $result;
    }

    public function failResponse()
    {

        return json_encode( ["contestId" => false, "message" => "No solution found."] );
    }

    public function successResponse($data)
    {

        return json_encode( ["success" => true, "message" => "Response has been sent to WubbaLubba", 'solution' => $data] );
    }

}


