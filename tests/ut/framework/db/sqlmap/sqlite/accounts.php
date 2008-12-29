<?php

$stm['AccountsAsArrayViaResultClass']=array
(
    'resultClass'=>'array',
    'sql'=><<<SQL
        select
        Account_Id as Id,
        Account_FirstName as FirstName,
        Account_LastName as LastName,
        Account_Email as EmailAddress
        from Accounts
        order by Account_Id
SQL
);

return $stm;
