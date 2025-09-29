<?php

namespace Nimp\LinkLoomCore\exceptions;

use Exception;

/**
 * Represents an exception specific to the URL shortener application.
 *
 * This exception can be used to handle errors related to the functionality
 * of shortening URLs, such as invalid input, system errors, or invalid state
 * during the URL processing.
 *
 * Extends the base Exception class to maintain consistency with other exceptions
 */
class UrlShortenerException extends Exception
{
}