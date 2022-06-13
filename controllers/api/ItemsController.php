<?php
include_once DIR_MODELS . "Announcement/AnnouncementDM.php";

class ItemsController extends Controller
{
    public function get_items()
    {
        $data_mapper = new AnnouncementDM();
        $data = $data_mapper->get_announcements(5, 0);
        echo '<pre>';
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}
