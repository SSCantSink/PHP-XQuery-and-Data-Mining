(:
  For each rep output
  Full name of the rep
  Number of customers associated with this rep
  Names of all customers associated with this rep
  Average balance value of these customers
  Query Output:
<results>
  <Rep FullName="Valerie Kaiser">
    <Customers Count="3"/>
    <Customer Name="Al's Appliance and Sport"/>
    <Customer Name="All Season"/>
    <Customer Name="Kline's"/>
    <CustBalance Average="$9,177.67"/>
  </Rep>
  <Rep FullName="Richard Hull">
    <Customers Count="4"/>
    <Customer Name="Brookings Direct"/>
    <Customer Name="Deerfield's Four Seasons"/>
    <Customer Name="Lee's Sport and Appliance"/>
    <Customer Name="The Everything Shop"/>
    <CustBalance Average="$2,203.94"/>
  </Rep>
  <Rep FullName="Juan Perez">
    <Customers Count="3"/>
    <Customer Name="Bargains Galore"/>
    <Customer Name="Ferguson's"/>
    <Customer Name="Johnson's Department Store"/>
    <CustBalance Average="$3,767.67"/>
  </Rep>
</results> 
:)

<results>
{
  for $rep in doc("../premiere/Rep.xml")//Rep
  return <Rep FullName="{$rep/FirstName} {$rep/LastName}">
  {
    let $cus := doc("../premiere/Customer.xml")//Customer[RepNum = $rep/RepNum]
    return <Customers Count="{count($cus)}"/>
  }
  {
    for $c in doc("../premiere/Customer.xml")//Customer[RepNum = $rep/RepNum]
    order by $c/CustomerName
    return <Customer Name="{$c/CustomerName}"/>
  }
  {
    let $cust := doc("../premiere/Customer.xml")//Customer[RepNum = $rep/RepNum]
    return <CustBalance Average="{format-number(avg($cust/Balance),  '$,000.00')}"/>
  }
  </Rep>
}
</results>
  