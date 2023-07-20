# CLI Script

CLI script which will read JSON based data from a specific endpoint via HTTP. The script will contain several sub-
commands to filter and output the loaded data. The commands should be:

👉 Find objects by price range (given price_from and price_to as arguments).

👉 Find objects by a certain sub-object definition.

# Command for CLI (Examples)
go to the project directory and copy/paste the following command
`php run.php count_by_price_range 12.00 145.80`

`php run.php count_by_vendor_id 42`

**Implementation :**

👉 Used PHP 8.2.

👉 Not used framework at all.

👉 Implemented the ReaderInterface for fetching the JSON HTTP endpoint and thus work with the OfferCollectionInterface and OfferInterface on the loaded data (see below). 

👉  Written at least one unit test for a small component of the script.

👉  Implemented logging.