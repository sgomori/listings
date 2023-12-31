<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**************************************************************
 *                                                            *
 *  Filename:       Listings_model.php                        *
 *  Description:    Listings model                            *
 *  Author:         Steve Gomori                              *
 *  Last Modified:  Feb 13, 2022                              *
 *                                                            *
 **************************************************************/ 

class Listings_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }

  public function get_all_listings($where = '')
  {
  
    $sql = '
        SELECT "res" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Listing.Last_Transaction_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name,
          Listing.Lat, Listing.Lon, Listing.Active
        FROM
        wpg_rets_property_res Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        WHERE Listing.Expiry_Date >= NOW()    
        '.$where.'
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "con" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Listing.Last_Transaction_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name,
          Listing.Lat, Listing.Lon, Listing.Active
        FROM
        wpg_rets_property_con Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID  
        WHERE Listing.Expiry_Date >= NOW()     
        '.$where.'
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "rur" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate, 
          Listing.Status, Listing.Sold_Date, Listing.Last_Transaction_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name,
          Listing.Lat, Listing.Lon, Listing.Active
        FROM
        wpg_rets_property_rur Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID     
        WHERE Listing.Expiry_Date >= NOW()
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
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_'.$type.' Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
          Listing.Active = 1
          OR
          Listing.Status LIKE "Sold"
          OR
          Listing.Status LIKE "Custom"
          OR
          Listing.Status LIKE "Pending"
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
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
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
        NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
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
        NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
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
        NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Listing.Last_Transaction_Date, Agent_1.First_Name AS Agent_1_First_Name, 
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
        Sold_Date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        AND
        (
          Listing.Matrix_Unique_ID > 100000
        )
              
        UNION
        
        SELECT "con" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Listing.Last_Transaction_Date, Agent_1.First_Name AS Agent_1_First_Name, 
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
        Sold_Date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        AND
        (
          Listing.Matrix_Unique_ID > 100000
        )
                      
        UNION
        
        SELECT "rur" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Listing.Last_Transaction_Date, Agent_1.First_Name AS Agent_1_First_Name, 
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
        Sold_Date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND NOW()
        AND
        (
          Listing.Sales_Rep_MUI_1 IN (564206, 16212643)
          OR
          Listing.Sales_Rep_MUI_2 IN (564206, 16212643)
        )
        AND
        (
          Listing.Matrix_Unique_ID > 100000
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
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_res Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID        
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Listing.Active = 1
          OR
          Status LIKE "Custom"
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
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_con Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID        
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Listing.Active = 1
          OR
          Status LIKE "Custom"
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
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate, 
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_rur Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID        
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Listing.Active = 1
          OR
          Status LIKE "Custom"
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
    
    
  public function search_current_listings_by_type($type, $where, $limit = FALSE)
  {
  
    $sql = '
        SELECT "'.$type.'" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_'.$type.' Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
          AND wpg_rets_openhouse_openhouse.IsDeleted = 0
        LEFT JOIN wpg_rets_agent_agent Agent_1 ON Listing.Sales_Rep_MUI_1 = Agent_1.Matrix_Unique_ID
        LEFT JOIN wpg_rets_agent_agent Agent_2 ON Listing.Sales_Rep_MUI_2 = Agent_2.Matrix_Unique_ID
        WHERE
        Listing.Expiry_Date >= NOW()
        AND
        (
          Listing.Active = 1
          OR
          Status LIKE "Custom"
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
        
    if ($limit)
    {
      $sql .= ' LIMIT '.$limit;
    }
    
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
          AND NOW() < Open_House.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
  
    if ($development === 'grantown forest')
    {
      $sql = '
          SELECT "res" ';
    }
    else
    {
      $sql = '
          SELECT "con" ';
    }
        
    $sql .= '
        AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM ';
        
    if ($development === 'grantown forest')
    {
      $sql .= '
          wpg_rets_property_res ';
    }
    else
    {
      $sql .= '
          wpg_rets_property_con ';
    }
    
    $sql .= '                    
        Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
        AND ';
        
    if ($development === 'meadowbrook villas')
    {
      $sql .= ' Condominium_Name LIKE "%meadowbrook%" ';
    }
    else if ($development === 'creekbend hollow')
    {
      $sql .= ' Condominium_Name LIKE "%creek bend%" OR Condominium_Name LIKE "%creekbend%"';
    }
    else if ($development === 'grantown forest')
    {
      $sql .= ' Street_Name LIKE "%jones%" OR Street_Name LIKE "%cuthbert%"';
    }    
    else
    {
      $sql .= ' Condominium_Name LIKE "'.$development.'" ';
    }
    
    $sql .= '  
      GROUP BY Listing.Matrix_Unique_ID 
      ORDER BY Sold_Date ASC, Date_Entered DESC';
    
  
    if ($query = $this->db->query($sql))
    {
      return $query;
    } 
    
    return FALSE;
  
  }  


  public function get_listings_by_street_search($search)
  {
  
    $sql = '
        SELECT "res" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_res Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
        AND Street_Name LIKE "%'.$search.'%"
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
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_res Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
          Listing.Active = 1
          OR
          Status LIKE "Custom"
        )
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "con" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_con Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
          Listing.Active = 1
          OR
          Status LIKE "Custom"
        )
        GROUP BY Listing.Matrix_Unique_ID
              
        UNION
        
        SELECT "rur" AS class, Listing.Matrix_Unique_ID, Listing.LastChangeTypeDate, Listing.Display_Addrs_on_Pub_Web_Sites,
          Listing.LastChangeType, Listing.Style, Listing.Suite_Number, Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Postal_Code,
          Listing.Public_Remarks, Listing.Total_FloorLiv_Area_SF, Listing.Number_of_Total_Baths, 
          Listing.Total_Bedrooms, Listing.CurrentPrice, Listing.Total_FloorLiv_Area_SF, 
          Listing.Number_of_Total_Baths, Listing.Total_Bedrooms, Listing.Date_Entered, Listing.Last_ImgTransDate, Listing.LastListPriceChangeDate,
          Listing.Status, Listing.Sold_Date, Open_House_Date_NUM1, Agent_1.First_Name AS Agent_1_First_Name, 
          Agent_1.Last_Name AS Agent_1_Last_Name, Agent_2.First_Name AS Agent_2_First_Name, 
          Agent_2.Last_Name AS Agent_2_Last_Name 
        FROM
        wpg_rets_property_rur Listing
        LEFT JOIN wpg_rets_openhouse_openhouse ON Listing.Matrix_Unique_ID = wpg_rets_openhouse_openhouse.Listing_MUI 
          AND NOW() < wpg_rets_openhouse_openhouse.Open_House_Date_NUM1 + INTERVAL 1 DAY
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
          Listing.Active = 1
          OR
          Status LIKE "Custom"
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
  

  public function get_pending_listings()
  {
  
    $sql = '
        SELECT "res" AS class, Listing.Matrix_Unique_ID,
          Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Status
        FROM
        wpg_rets_property_res Listing
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
        Status LIKE "Pending"
              
        UNION
        
        SELECT "con" AS class, Listing.Matrix_Unique_ID,
          Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Status
        FROM
        wpg_rets_property_con Listing
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
        Status LIKE "Pending"
              
        UNION
        
        SELECT "rur" AS class, Listing.Matrix_Unique_ID,
          Listing.Street_Number, Listing.Street_Name, 
          Listing.Street_Type, Listing.Neighbourhood, Listing.City_or_Town_Name, Listing.Status
        FROM
        wpg_rets_property_rur Listing
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
        Status LIKE "Pending"';
    
  
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
  
  
	public function update_status_to_sold($class, $matrix_unique_id)
	{
    
    $sql = '
        UPDATE wpg_rets_property_'.$class.'
        SET
          Status = "Sold",
          Sold_Date = NOW(),
          Status_Change_Date = NOW()
        WHERE Matrix_Unique_ID = '.$matrix_unique_id;
    
    if ($query = $this->db->query($sql));
    {
      return 1;
    }
    
    return 0;
	}


	public function update_status_to_inactive($class, $matrix_unique_id)
	{
    
    $sql = '
        UPDATE wpg_rets_property_'.$class.'
        SET
          Status = "Inactive",
          Active = 0
        WHERE Matrix_Unique_ID = '.$matrix_unique_id;
    
    if ($query = $this->db->query($sql));
    {
      return 1;
    }
    
    return 0;
	}
  	
	
	public function update_status($class, $matrix_unique_id, $status)
	{
    
    $sql = '
        UPDATE wpg_rets_property_'.$class.'
        SET
          Status = "'.$status.'",
          Sold_Date = "0000-00-00 00:00:00",
          Active = 1
        WHERE Matrix_Unique_ID = '.$matrix_unique_id;
    
    if ($query = $this->db->query($sql));
    {
      return 1;
    }
    
    return 0;
	}
	
	
	public function set_coordinates($class, $matrix_unique_id, $lat, $lon)
	{
    
    $sql = '
        UPDATE wpg_rets_property_'.$class.'
        SET
          Lat = "'.$lat.'",
          Lon = "'.$lon.'"
        WHERE Matrix_Unique_ID = '.$matrix_unique_id;
    
    $this->db->query($sql);
    
	}
	
	
	public function update_map_marker($data)
	{
    $sql = '
        UPDATE wpg_rets_property_'.$data['class'].'
        SET
          Lat = "'.$data['lat'].'",
          Lon = "'.$data['lon'].'"
        WHERE Matrix_Unique_ID = '.$data['matrix_unique_id'];
    
    if ($query = $this->db->query($sql));
    {
      return 1;
    }
    
    return 0;
	}
}

/* End of file Listing_model.php */
/* Location: ./listings_app/models/Listing_model.php  */