<?php

namespace App\Http\Controllers;

class HomeController
{

    public function index()
    {
        $categories = [
            [
                "CategoryName" =>  "Clothies Category",
                "Products" => [
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],

                ]
            ],
            [
                "CategoryName" =>  "Clothies Category",
                "Products" => [
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],
                    [
                        "ProductName" => "orange",
                        "ProductImage" => "https://www.bigfootdigital.co.uk/wp-content/uploads/2020/07/image-optimisation-scaled.jpg",
                        "ProductPrice" => 123
                    ],

                ]
            ]
        ];

        view("home", [
            "categories" => $categories
        ]);
    }
}
