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

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Save settings to session or database
            $_SESSION['settings'] = $_POST;

            // Redirect back to the settings page
            header('Location: ' . ROOT . '/settings');
        }
    }
}