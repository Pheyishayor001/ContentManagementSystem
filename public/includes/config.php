<?php
// Initiating output buffering to prevent accidental output
ob_start();

// Starting the session
session_start();

// Flushing the output buffer
ob_end_flush();
