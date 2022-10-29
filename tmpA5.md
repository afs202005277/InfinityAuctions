## A5: Relational Schema, validation and schema refinement

> This artifact contains the Relational Schema obtained by mapping from the Conceptual Data Model. 
### 1. Relational Schema

> The Relational Schema includes the relation schemas, attributes, domains, primary keys, foreign keys and other integrity rules: UNIQUE, DEFAULT, NOT NULL, CHECK.  
> Relation schemas are specified in the compact notation:  

| Relation reference | Relation Compact Notation                        |
| ------------------ | ------------------------------------------------ |
| R01 | general_user( <ins>id</ins>, name **NN**, gender **CK** gender IN Gender, cellphone **UK**, email **UK**, birth_date **NN**, address **UK**, password **NN**, rate **CK** rate >= 0 AND rate <= 5, credits, wishlist, is_admin **NN** ) |
| R02 | bid( <ins>id</ins>, date **NN** **DF** Today, amount **NN**, user_id -> general_user **NN**, auction_id -> auction **NN**) |
| R03 | notification (<ins>id</ins>, date **DF** Today **NN**, type **NN** **CK** type IN Notification_type, user_id -> general_user **NN**, auction_id -> auction, report_id -> report) |
| R04 | auction (<ins>id</ins>, name **NN**, description **NN**, base_price **NN**, start_date **NN** **DF** Today, end_date **NN** **CK** start_date < end_date, buy_now, state **NN**, auction_owner_id -> general_user **NN** ) |
| R05 | category ( <ins>id</ins>, name **NN** **UK**) |
| R06 | auction_category ( <ins>category_id</ins> -> category, <ins>auction_id</ins> -> auction) |
| R07 | following ( <ins>user_id</ins> -> general_user, <ins>auction_id</ins>-> auction ) |
| R08 | report (<ins>id</ins>, date **DF** Today **NN**, penalty **CK** penalty IN Penalty, reported_user -> general_user, reporter -> general_user **NN** **CK** reported_user != reporter, auction_reported -> auction, admin_id -> general_user) |
| R09 | report_option ( <ins>id</ins>, name **NN** **UK**) |
| R10 | report_reasons ( <ins>id_report_option</ins> -> report_option, <ins>id_report</ins> -> report) |

* Legend:
  - **UK** = UNIQUE KEY
  - **NN** = NOT NULL
  - **DF** = DEFAULT
  - **CK** = CHECK

 
**Justification for Generalizations**
 | Generalization | Justification           |
| ----------- | --------------------------------------------- |
| **User / Admin / General User** | Since the differences between an User and an Admin are few, we chose to generalize this using null fields in certain columns, namely: address, rate, credits and wishlist. Furthermore, we added a collumn named "isAdmin" that is composed of boolean values and is used to check if a given user is an Admin or not.|
| **Reports / Auction Reports / User Reports** | Once again Auction reports share the vast majority of their attributes and therefore it makes more sense to simply use nulls to express the difference between both of them.|


### 2. Domains

> The specification of additional domains can also be made in a compact form, using the notation:  

| Domain Name | Domain Specification           |
| ----------- | ------------------------------ |
| Today | DATE DEFAULT CURRENT_DATE  |
| Notification_type | ENUM ('Outbid', 'New Auction', 'Report', 'Wishlist Targeted', ‘Auction Ending’, ‘New Bid’, ‘Auction Ended’, ‘Auction Won’, ‘Auction Canceled’ ) |
| State | ENUM ('Cancelled', 'Running', 'To be started', 'Ended') |
| Penalty | ENUM ('3 day ban', '5 day ban', '10 day ban', '1 month ban', 'Banned for life') |
| Gender | ENUM (‘M’, ‘F’, ‘NB’, ‘O’) |

### 3. Schema validation

> To validate the Relational Schema obtained from the Conceptual Model, all functional dependencies are identified and the normalization of all relation schemas is accomplished. Should it be necessary, in case the scheme is not in the Boyce–Codd Normal Form (BCNF), the relational schema is refined using normalization.  

<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R01 </strong>(general_user)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{id}, {cellphone}, {email}, {address}</td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD0101</td>
    <td colspan="2"> {id} -> {name, gender, cellphone, email, birth_date, address, password, rate, credits , wishlist, is_admin} </td>
  </tr>
  <tr>
    <td colspan="2">FD0102</td>
    <td colspan="2">{cellphone} -> {id, name, gender, email, birth_date, address, password, rate, credits , wishlist, is_admin}</td>
  </tr>
  <tr>
    <td colspan="2">FD0103</td>
    <td colspan="2">{email} -> {id, name, gender, cellphone, birth_date, address, password, rate, credits , wishlist, is_admin}</td>
  </tr>
    <tr>
    <td colspan="2">FD0104</td>
    <td colspan="2">{address} -> {id, name, gender, cellphone, email, birth_date, password, rate, credits , wishlist, is_admin}</td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>
 

<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R02 </strong>(bid)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{id}</td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD0201</td>
    <td colspan="2"> {id} -> {date, amount, user_id -> general_user, auction_id -> auction} </td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>

<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R03 </strong>(notification)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{id}</td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD0301</td>
    <td colspan="2"> {id} -> {date, type, user_id -> general_user, auction_id -> auction, report_id -> report} </td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>

<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R04 </strong>(auction)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{id}</td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD0401</td>
    <td colspan="2"> {id} -> {name, description, base_price, start_date, end_date, buy_now, state, auction_owner_id -> general_user} </td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>

<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R05 </strong>(category)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{id}, {name}</td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD0501</td>
    <td colspan="2"> {id} -> {name} </td>
  </tr>
   <tr>
    <td colspan="2">FD0502</td>
    <td colspan="2"> {name} -> {id} </td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>
 
<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R06 </strong>(auction_category)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{category_id, auction_id}</td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD0601</td>
    <td colspan="2"> none </td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>

<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R07 </strong>(following)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{user_id, auction_id}</td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD0701</td>
    <td colspan="2"> none </td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>

<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R08 </strong>(report)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{id}</td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD0801</td>
    <td colspan="2"> {id} -> {date, penalty, reported_user -> general_user, reporter -> general_user, auction_reported -> auction, admin_id-> general_user} </td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>

<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R09 </strong>(report_option)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{id, name}</td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD0901</td>
    <td colspan="2"> {id} -> {name} </td>
  </tr>
    <tr>
    <td colspan="2">FD0902</td>
    <td colspan="2"> {name} -> {id} </td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>

<table>
<thead>
  <tr>
    <td colspan="4"> <strong> Table R10 </strong>(report_reasons)</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="4"> <strong> Keys: </strong>{id_report_option, id_report} </td>
  </tr>
  <tr>
    <td colspan="4"> <strong> Functional Dependencies </strong> </td>
  </tr>
  <tr>
    <td colspan="2">FD1001</td>
    <td colspan="2"> none </td>
  </tr>
  <tr>
    <td colspan="2"><strong> Normal Form </strong> </td>
    <td colspan="2">BCNF</td>
  </tr>
</tbody>
</table>
