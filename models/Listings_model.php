<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**************************************************************
 *                                                            *
 *  Filename:       ListingS_model.php                        *
 *  Description:    ListingS model                            *
 *  Author:         Steve Gomori, sgomori at vividwind com    *
 *  Last Modified:  Oct 28, 2015                              *
 *                                                            *
 **************************************************************/ 

class ListingS_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }

  public function get_all_listings($where = '')
  {
  
    $sql = '
        SELECT "res" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_res Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        WHERE Listing.Expiry_Date >= NOW()
        AND      
        '.$where.'
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "con" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_con Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID  
        WHERE Listing.Expiry_Date >= NOW()  
        AND    
        '.$where.'
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "rur" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_rur Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID     
        WHERE Listing.Expiry_Date >= NOW()
        AND
        '.$where.'
        GROUP BY Listing.Matrix_Unique_ID      
        
        ORDER BY Sold_Date ASC, Date_Entered DESC';
    
  
    if ($query = $this->db->query($sql))
    {
      return $query;
    } 
    
    return FALSE;
  
  }
    
    
  public function get_listings_by_type($type)
  {
  
    $sql = '
        SELECT "'.$type.'" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_'.$type.' Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID        
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        GROUP BY Listing.Matrix_Unique_ID 
        ORDER BY Sold_Date ASC, Date_Entered DESC';
    
  
    if ($query = $this->db->query($sql))
    {
      return $query;
    } 
    
    return FALSE;
  
  }


  public function get_open_houses()
  {
  
    $sql = '
        SELECT "res" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_res Listing
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.ML_Number = wpg_rets_openhouse_openhouse.ML_Number
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        Open_House_Date_NUM1 > NOW()
        AND
        wpg_rets_openhouse_openhouse.IsDeleted = 0
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "con" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_con Listing
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.ML_Number = wpg_rets_openhouse_openhouse.ML_Number
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        Open_House_Date_NUM1 > NOW()
        AND
        wpg_rets_openhouse_openhouse.IsDeleted = 0
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "rur" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_rur Listing
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.ML_Number = wpg_rets_openhouse_openhouse.ML_Number
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        Open_House_Date_NUM1 > NOW()
        AND
        wpg_rets_openhouse_openhouse.IsDeleted = 0
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        GROUP BY Listing.Matrix_Unique_ID
              
        ORDER BY Open_House_Date_NUM1 ASC';
    
  
    if ($query = $this->db->query($sql))
    {
      return $query;
    } 
    
    return FALSE;
  
  }  
  
  
  public function get_sold_listings()
  {
  
    $sql = '
        SELECT "res" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_res Listing
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        WHERE
        Status LIKE "Sold"
        AND
        Sold_Date != "0000-00-00 00:00:00"
        AND
        Sold_Date < NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
              
        UNION
        
        SELECT "con" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_con Listing
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        WHERE
        Status LIKE "Sold"
        AND
        Sold_Date != "0000-00-00 00:00:00"
        AND
        Sold_Date < NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
              
        UNION
        
        SELECT "rur" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_rur Listing
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        WHERE
        Status LIKE "Sold"
        AND
        Sold_Date != "0000-00-00 00:00:00"
        AND
        Sold_Date < NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
              
        ORDER BY Sold_Date DESC';
    
  
    if ($query = $this->db->query($sql))
    {
      return $query;
    } 
    
    return FALSE;
  
  } 


  public function search_current_listings($where)
  {
  
    $sql = '
        SELECT "res" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_res Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID        
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Sold_Date > NOW()
          OR
          Sold_Date = "0000-00-00 00:00:00"
        )
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )'
        .$where.'
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "con" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_con Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID        
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Sold_Date > NOW()
          OR
          Sold_Date = "0000-00-00 00:00:00"
        )
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )'
        .$where.'
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "rur" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_rur Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID        
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Sold_Date > NOW()
          OR
          Sold_Date = "0000-00-00 00:00:00"
        )
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )'
        .$where.'
        GROUP BY Listing.Matrix_Unique_ID
        
        ORDER BY Date_Entered DESC';
    
  
    if ($query = $this->db->query($sql))
    {
      return $query;
    } 
    
    return FALSE;
  
  }
    
    
  public function search_current_listings_by_type($type, $where)
  {
  
    $sql = '
        SELECT "'.$type.'" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_'.$type.' Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Sold_Date > NOW()
          OR
          Sold_Date = "0000-00-00 00:00:00"
        )
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )'
        .$where.'
        GROUP BY Listing.Matrix_Unique_ID 
        ORDER BY Date_Entered DESC';
    
    if ($query = $this->db->query($sql))
    {
      return $query;
    } 
    
    return FALSE;
  
  }
    
 
  public function get_property_detail($class, $matrix_unique_id)
  {
  
    $sql = '
        SELECT Property.*, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name,
          Open_House.Directions, Open_House.FromTime, Open_House.Heading_CAPS,
          Open_House.Open_House_Date_NUM1, Open_House.Remarks, Open_House.ToTime
        FROM
        wpg_rets_property_'.$class.' Property
        LEFT JOIN wpg_rets_openhouse_openhouse Open_House ON Property.Matrix_Unique_ID = Open_House.Listing_MUI 
          AND Open_House.Open_House_Date_NUM1 > NOW() 
          AND Open_House.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Property.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Property.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        WHERE 
        Property.Matrix_Unique_ID = '.$matrix_unique_id.'
        ORDER BY Open_House.InputEntryOrder ASC';
    
    if ($query = $this->db->query($sql))
    {
      return $query;
    }
    
    return FALSE;
  }


  public function get_development_listings($development)
  {
  
    $sql = '
        SELECT "con" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_con Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID        
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        AND
        Condominium_Name LIKE "'.$development.'"
        GROUP BY Listing.Matrix_Unique_ID 
        ORDER BY Sold_Date ASC, Date_Entered DESC';
    
  
    if ($query = $this->db->query($sql))
    {
      return $query;
    } 
    
    return FALSE;
  
  }  


  public function get_latest_listings($limit)
  {
    $sql = '
        SELECT "res" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_res Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        AND
        (
          Sold_Date > NOW()
          OR
          Sold_Date = "0000-00-00 00:00:00"
        )
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "con" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_con Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID  
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        AND
        (
          Sold_Date > NOW()
          OR
          Sold_Date = "0000-00-00 00:00:00"
        )
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "rur" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, 
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_rur Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND Open_House_Date_NUM1 > NOW()
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID     
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        AND
        (
          Sold_Date > NOW()
          OR
          Sold_Date = "0000-00-00 00:00:00"
        )

        GROUP BY Listing.Matrix_Unique_ID      
        
        ORDER BY Date_Entered DESC
        LIMIT '.$limit;  
    
  
    if ($query = $this->db->query($sql))
    {
      return $query;
    } 
    
    return FALSE;
  
  } 
  
  
  public function get_room_detail($matrix_unique_id)
  {
    $this->db->where(array('listing_MUI' => $matrix_unique_id));
    $this->db->order_by('InputEntryOrder', 'ASC');
    
    if ($query = $this->db->get('rooms_rooms'));
    {
      return $query;
    }
    
    return FALSE;
  }
}

/* End of file Listing_model.php */
/* Location: ./listings_app/models/Listing_model.php  */