<?php

class Settings extends Controller
{
    public function index()
    {
        // Load existing settings from session or database
        $settings = isset($_SESSION['settings']) ? $_SESSION['settings'] : [];

        $settings = new Setting();

        $activityLogs = $settings->getActivityLogs();

        // Load the settings view
        $this->view('settings', ['settings' => $settings,
                                    'activityLogs' => $activityLogs]);
    }    

    public function archiveViolations()
    {
        $settings = new Setting();
        $settings->archiveResolvedViolations();

        // Optionally, you can set a flash message to indicate success
        $_SESSION['flash_message'] = "Resolved violations have been archived successfully.";

        // Redirect back to the settings page
        header("Location: /settings");
        exit();

        
    }
}