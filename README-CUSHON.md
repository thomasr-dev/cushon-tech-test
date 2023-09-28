# Technical notes
## System requirements
The Yii 2 framework is used, with PHP 7.4 required by the framework version I have used.
Please note that I have developed and tested the application in a PHP 8.1 environment.

A MySQL or MariaDB database server is required; I have used MariaDB 10.6.14.

This in turn requires PHP to have the PDO extension available, with the MySQL driver available.

Most other SQL based databases will probably work, but these have not been tested.

## How to set up and run
Run `composer install` to download and install all required PHP libraries.

Create a new MySQL / MariaDB database.

Edit config/db.php to include the correct database connection details.

Connect to the database and run the SQL commands in database/create-tables.sql

In the project root directory, run `php yii serve` to start PHP's embedded web server on port 8080. If this port is
not usable for any reason, you can use the `--port` argument to specify an alternative port number. Please see
https://www.yiiframework.com/doc/guide/2.0/en/start-installation#verifying-installation for further information.

NB to use the application with a production web server, set the document root to the web directory, and ensure that any
requests for non-existent paths are routed to index.php.

# Notes on the scenario

## General notes
As this is an example scenario, to be completed in my own time, I have made numerous assumptions regarding the
requirements, which I have documented below. If this was a real assignment to be completed as part of employment, I
would clarify these requirements, as well as confirming my correct understanding of the relevant domain knowledge,
before starting work.

## Research findings
I have a basic knowledge of ISAs and their operation, but before starting work, I carried out further research into the
rules governing them on both the UK Government website at https://www.gov.uk/individual-savings-accounts and Cushon's
own website.

My key findings from this were as follows:

* Multiple types of ISA exist: Cash, Stocks and Shared, Lifetime, Innovative Finance and Junior.
* An individual can only invest in a single ISA account of each type during each tax year.
* Junior ISAs are legally speaking owned by a child (aged under 18), but until the account holder turns 16, they must be managed by an adult on the child's behalf. An adult is allowed to manage ISAs (including investing into them) for more than one child.
* For junior ISAs, there is a maximum amount that can be invested during each tax year. This limit is set each year by the government, and for the 2023/24 tax year is £9000.
* For all other ISA types, there is a similar maximum amount, which for 2023/24 is £20,000. This limit applies across all non-junior ISAs (e.g. you could invest £10,000 in a stocks and shares ISA and £10,000 in a lifetime ISA, and then your yearly allowance would be used up and no further investment would be permitted).
  * NB the scenario gives an example of a customer who wishes to deposit £25,000, which based on the current ISA limit should not be permitted.
* If a withdrawal is made from an ISA, then the annual deposit limit is sometimes increased by the amount withdrawn (referred to as a flexible ISA). Whether an ISA is flexible or not is decided by the account provider.
* Funds can be transferred to another ISA at any time. This does *not* count as a withdrawal (so there is no tax penalty), and I believe it also does not count as a deposit, and so does not affect the annual deposit limit.
* Cushon currently offer stocks and shares, lifetime and junior ISAs.

## Assumptions made
I have assumed that the actual transfer of funds is out of scope for this task, and that either transfer of the required
funds into Cushon has already been made, or will be made by a separate process later (i.e. in the latter case, we are
simply recording a customer's wish to make an investment, rather than actually making the investment immediately).

There is no mention of withdrawals or ISA transfers in the scenario presented, and I have therefore assumed that these
are considered out of scope for this task. If these were required, I would recommend adding some kind of immutable
transaction log to ensure that all money moving in or out of the account can always be accounted for.

I have further assumed that we should not attempt to calculate interest payments, again due to this not being mentioned
in the scenario documentation.

I have assumed that we should attempt to enforce the government rules on ISAs, in particular then only allowing
investments into a single ISA during each tax year, and limiting the total deposits made each tax year in accordance
with the limit from https://www.gov.uk/individual-savings-accounts.

## Choices made
I have chosen to implement the system as a REST API using OAuth authentication. This should allow the same backend
to be used by both a web frontend (potentially using React or similar) and native mobile apps, as noted in the scenario
description.

I have chosen to use the Yii PHP framework, due to both my own familiarity with it in my current role and it already
being used within Cushon.

I have used MySQL / MariaDB as the database due to my familiarity with it and its wide availability. Due to the use of
Yii's Active Record ORM, use of an alternative database should hopefully be an easy, almost drop-in replacement.

Due to the complexities introduced by junior ISAs (a lower annual investment limit, which is not shared with other ISAs), I have chosen not to implement them in my submission.

As withdrawals are not supported, my submission will not support flexible ISAs, as with no way to withdraw money then making an ISA flexible will have no effect.

## Future enhancements
* Implement a proper database migrations system rather than simple SQL files to be run manually
* Add MFA and potentially require customers to use it
* Implement a more flexible permissions system so that support staff can view and potentially modify data, and the platform can support "financial deputyship" in which a person is authorised to open and manage an ISA on someone else's behalf
* Ability to restrict fund availability (e.g. some funds may not be available for all ISA products offered).
* Retrieve database configuration from the environment rather than a config file
* Add support for junior ISAs.
* Maximum possible code coverage with unit tests
* Support flexible ISAs. This implies either handling withdrawals within this system, or having some means of another system informing this one of withdrawals that have been made.