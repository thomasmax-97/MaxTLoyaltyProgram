  # Shopware 6 Loyalty Program Plugin

**Description**
The Loyalty Program Plugin introduces a loyalty program that rewards customers with points based on their purchasing and engagement behavior on the platform.
The main features of the plugin are as follows:
1.  **Earning Points**:
    
    -   Customers can earn points from two actions:
        -   Making purchases: The administrator can configure a variable 'X' such that for every euro spent, the customer receives 'X' points. This can be easily set up in the Shopware admin area.
        -   Commenting on products: The administrator can set a fixed number of points in the plugin configuration that customers earn for each product comment they make in the admin area.
2.  **Points Display**:
    
    - Customers can easily view their total accumulated points in their account dashboard. This allows them to keep track of their loyalty points and incentivizes further engagement with the platform.
    
1.  **Administrator Access**:
    
    - Administrators have the ability to view the bonus points of all customers in the Shopware admin area. The exact location within the admin area is designed to be user-friendly and intuitive.
      
2.  **Extended Shopware API**:
    
    -   The plugin extends the Shopware API to include the bonus points of a customer. This ensures seamless integration with other plugins or custom solutions that may require access to this data.


## Installation

To install the Shopware 6 Loyalty Program Plugin, follow these steps:

1.  Clone this Git repository to your local machine or download the plugin ZIP file.
2.  Copy the plugin folder or clone it into the static Shopware plugins directory (`custom/static-plugins/`).
3. Run (`composer-require "maxt/loyalty-program"`).
4.  Access the Shopware admin area and navigate to "Extensions" > "My extensions."
5.  Locate the "Loyalty Program" plugin in the plugin list and click "Install."
6.  Once the installation is complete, click "Activate" to enable the plugin.

## Configuration

After the plugin is activated, administrators can easily configure the loyalty program settings from the Shopware admin area in the plugin settings:

1.  Set the points conversion rate: Define the variable 'X' to determine how many points customers receive for every euro spent.
2.  Set comment points: Specify the fixed number of points customers earn for each product comment they make.

## Compatibility

The Shopware 6 Loyalty Program Plugin is fully compatible with Shopware 6 version 6.4. It has been designed to work seamlessly with a standard Shopware 6 instance without requiring any additional customizations or configurations. I recommend to run it with php 8.1.

## Tests

To run the tests and seeders navigate into the plugin directory and run `bin/phpunit.sh`.  Alternatively you can run the tests separately with your IDE if you are using PhpStorm. Be aware to set the right path for the bootstrap & phpunit.xml files (from the plugin).




