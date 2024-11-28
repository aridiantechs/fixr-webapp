<?php
namespace App\Http\Controllers;

use App;
use Illuminate\Http\RedirectResponse;

class LocalizationController extends Controller
{
    /**
     * @param $locale
     * @return RedirectResponse
     */
    public function index($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

    // function to return strings
    public static function getString($lang)
    {
        switch ($lang) {
            case 'en':
                return[
                    "splash_screens"=> [ 
                        [
                            "heading"=> "01",
                            "sub_heading" => "All Your Services In One Place",
                            "icon" => "http://sanad-app.test/backend/assets/images/splash_1.png",
                            "button" => "Next"
                        ],
                        [
                            "heading"=> "02",
                            "sub_heading" => "High Safety and Reliability",
                            "icon" => "http://sanad-app.test/backend/assets/images/splash_2.png",
                            "button" => "Next"
                        ],
                        [
                            "heading"=> "03",
                            "sub_heading" => "Lowest Prices and Best Offers",
                            "icon" => "http://sanad-app.test/backend/assets/images/splash_3.png",
                            "button" => "Get Started"
                        ]
                    ],
                    
                    "login_icon" => "http://sanad-app.test/backend/assets/images/login.png",
                    "login_heading" => "Login",
                    "login_sub_heading" => "Welcome to Sanad App",
                    "login_description" => "A  4 digit code will be sent via SMS",
                    "login_button_1"=> "Get Started",
                    "login_button_2" => "Login as guest",
        
                    "otp_heading" => "OTP Verification",
                    "otp_sub_heading" => "Enter the OTP you received to",
                    "otp_resend_otp" => "Resend OTP",
                    "otp_button" => "Get Started",
        
                    "profile_title" => "Your Profile",
                    "profile_heading" => "Complete Your Profile",
                    "profile_button" => "Submit",
        
                    "location_icon" => "http://sanad-app.test/backend/assets/images/add_location.png",
                    "location_heading" => "Allow Sanad to access your location",
                    "location_sub_heading" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
                    "location_button" => "Next",
                    "location_title" => "Location",
                    
                    "your_location_title" => "Your Location",
                    "your_location_heading" => "Select Your Location",
                    "your_location_button" => "Add New Location",
        
                    "add_location_title" => "Add Location",
                    "add_location_heading" => "Add New Location",
                    "add_location_input_1" => "Location Name",
                    "add_location_input_2" => "Location Icon",
                    "add_location_input_3" => "Location Description",
        
                    "main_title" => "Welcome back",
                    "main_heading" => "Best Services",
                    "main_nav_btn_1" => "Home",
                    "main_nav_btn_2" => "Search",
                    "main_nav_btn_3" => "Offers",
                    "main_nav_btn_4" => "Profile",
        
                    "search_title" => "Search",
                    "search_switch_1" => "Hourly Service",
                    "search_switch_2" => "Stay In Service",
                    "search_heading" => "Choose a Service",
                    "search_search_op1" => "Contract Type",
                    "search_search_op2" => "Repeat",
                    "search_search_op3" => "Contract Duration",
                    "search_search_op4" => "Start From",
                    "search_search_op5"=> "Visits Time",
                    "search_search_op6" => "Your Location",
                    "search_button"=> "Search",
        
                    "search_result_title" => "Search",
                    "search_result_heading"=> "Results Found",
        
                    "filter_title" => "Filter",
                    "filter_heading" => "Filter & Sort",
                    "filter_op1" => "Sort by",
                    "filter_op2" => "Nationality",
                    "filter_op3" => "Price",
                    "filter_op4" => "Rating",
                    "filter_op5" => "Service Providers",
                    "filter_button" => "Submit",
        
                    "offer_details_heading_1" => "Service Provider",
                    "offer_details_heading_2" => "Order Description",
                    "offer_details_heading_3" => "Order Details",
                    "offer_details_heading_4" => "Price Details",
                    "offer_details_sub_total" => "Sub Total",
                    "offer_details_vat" => "VAT",
                    "offer_details_discount" => "Discount",
                    "offer_details_total" => "Order Total",
                    "offer_details_button" => "Order Now",
                    
                    "order_failed_icon" => "http://sanad-app.test/backend/assets/images/order_failed.png",
                    "order_failed_heading" => "Order Failed",
                    "order_failed_sub_heading" => "Order Success Page Order Success Page Order Success Page Order Success Page Order Success Page Order Success Page ",
                    "order_failed_button" => "Help & Support",
        
                    "order_success_icon" => "http://sanad-app.test/backend/assets/images/order_success.png",
                    "order_success_heading" => "Order Success",
                    "order_success_sub_heading" => "Order Success Page Order Success Page Order Success Page Order Success Page Order Success Page Order Success Page ",
                    "order_success_button" => "Home Page",
                    
                    "contact_us_title" => "Contact Us",
                    "contact_us_heading" => "Contact Us",
                    "contact_us_cards"=> [ 
                        [
                            "icon" => "http://sanad-app.test/backend/assets/images/phone.png",
                            "heading"=> "Support",
                            "description" => "Chat with us",
                        ],
                        [
                            "icon" => "http://sanad-app.test/backend/assets/images/phone.png",
                            "heading"=> "00966556890156",
                            "description" => "Call us",
                        ],
                        [
                            "icon" => "http://sanad-app.test/backend/assets/images/phone.png",
                            "heading"=> "Suggestions",
                            "description" => "Send email",
                        ],
                        [
                            "icon" => "http://sanad-app.test/backend/assets/images/phone.png",
                            "heading"=> "Riyadh",
                            "description" => "Saudi Arabia",
                        ]
                    ],
                ];
                break;
            
            default:
                return[
                    "splash_screens"=> [ 
                        [
                            "heading"=> "01",
                            "sub_heading" => "All Your Services In One Place",
                            "icon" => "http://sanad-app.test/backend/assets/images/splash_1.png",
                            "button" => "Next"
                        ],
                        [
                            "heading"=> "02",
                            "sub_heading" => "High Safety and Reliability",
                            "icon" => "http://sanad-app.test/backend/assets/images/splash_2.png",
                            "button" => "Next"
                        ],
                        [
                            "heading"=> "03",
                            "sub_heading" => "Lowest Prices and Best Offers",
                            "icon" => "http://sanad-app.test/backend/assets/images/splash_3.png",
                            "button" => "Get Started"
                        ]
                    ],
                    
                    "login_icon" => "http://sanad-app.test/backend/assets/images/login.png",
                    "login_heading" => "Login",
                    "login_sub_heading" => "Welcome to Sanad App",
                    "login_description" => "A  4 digit code will be sent via SMS",
                    "login_button_1"=> "Get Started",
                    "login_button_2" => "Login as guest",
        
                    "otp_heading" => "OTP Verification",
                    "otp_sub_heading" => "Enter the OTP you received to",
                    "otp_resend_otp" => "Resend OTP",
                    "otp_button" => "Get Started",
        
                    "profile_title" => "Your Profile",
                    "profile_heading" => "Complete Your Profile",
                    "profile_button" => "Submit",
        
                    "location_icon" => "http://sanad-app.test/backend/assets/images/add_location.png",
                    "location_heading" => "Allow Sanad to access your location",
                    "location_sub_heading" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
                    "location_button" => "Next",
                    "location_title" => "Location",
                    
                    "your_location_title" => "Your Location",
                    "your_location_heading" => "Select Your Location",
                    "your_location_button" => "Add New Location",
        
                    "add_location_title" => "Add Location",
                    "add_location_heading" => "Add New Location",
                    "add_location_input_1" => "Location Name",
                    "add_location_input_2" => "Location Icon",
                    "add_location_input_3" => "Location Description",
        
                    "main_title" => "Welcome back",
                    "main_heading" => "Best Services",
                    "main_nav_btn_1" => "Home",
                    "main_nav_btn_2" => "Search",
                    "main_nav_btn_3" => "Offers",
                    "main_nav_btn_4" => "Profile",
        
                    "search_title" => "Search",
                    "search_switch_1" => "Hourly Service",
                    "search_switch_2" => "Stay In Service",
                    "search_heading" => "Choose a Service",
                    "search_search_op1" => "Contract Type",
                    "search_search_op2" => "Repeat",
                    "search_search_op3" => "Contract Duration",
                    "search_search_op4" => "Start From",
                    "search_search_op5"=> "Visits Time",
                    "search_search_op6" => "Your Location",
                    "search_button"=> "Search",
        
                    "search_result_title" => "Search",
                    "search_result_heading"=> "Results Found",
        
                    "filter_title" => "Filter",
                    "filter_heading" => "Filter & Sort",
                    "filter_op1" => "Sort by",
                    "filter_op2" => "Nationality",
                    "filter_op3" => "Price",
                    "filter_op4" => "Rating",
                    "filter_op5" => "Service Providers",
                    "filter_button" => "Submit",
        
                    "offer_details_heading_1" => "Service Provider",
                    "offer_details_heading_2" => "Order Description",
                    "offer_details_heading_3" => "Order Details",
                    "offer_details_heading_4" => "Price Details",
                    "offer_details_sub_total" => "Sub Total",
                    "offer_details_vat" => "VAT",
                    "offer_details_discount" => "Discount",
                    "offer_details_total" => "Order Total",
                    "offer_details_button" => "Order Now",
                    
                    "order_failed_icon" => "http://sanad-app.test/backend/assets/images/order_failed.png",
                    "order_failed_heading" => "Order Failed",
                    "order_failed_sub_heading" => "Order Success Page Order Success Page Order Success Page Order Success Page Order Success Page Order Success Page ",
                    "order_failed_button" => "Help & Support",
        
                    "order_success_icon" => "http://sanad-app.test/backend/assets/images/order_success.png",
                    "order_success_heading" => "Order Success",
                    "order_success_sub_heading" => "Order Success Page Order Success Page Order Success Page Order Success Page Order Success Page Order Success Page ",
                    "order_success_button" => "Home Page",

                    "contact_us_title" => "Contact Us",
                    "contact_us_heading" => "Contact Us",
                    "contact_us_cards"=> [ 
                        [
                            "icon" => "http://sanad-app.test/backend/assets/images/phone.png",
                            "heading"=> "Support",
                            "description" => "Chat with us",
                        ],
                        [
                            "icon" => "http://sanad-app.test/backend/assets/images/phone.png",
                            "heading"=> "00966556890156",
                            "description" => "Call us",
                        ],
                        [
                            "icon" => "http://sanad-app.test/backend/assets/images/phone.png",
                            "heading"=> "Suggestions",
                            "description" => "Send email",
                        ],
                        [
                            "icon" => "http://sanad-app.test/backend/assets/images/phone.png",
                            "heading"=> "Riyadh",
                            "description" => "Saudi Arabia",
                        ]
                    ],
                ];
                break;
        }
    }
}