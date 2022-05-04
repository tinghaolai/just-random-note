OpenNMS And Others
===

## OpenNMS
network management system / network management station
ER diagram
* 使用icmp ping 定時監控node及其服務
    * node監控:node被發現掛了 會回去看這path 如果上層也掛, node down就會被壓抑
    * 服務監控:DHCP DNS SNMP SMTP SSH...
        * 較為複雜的diskUsage
        * 如果是node掛 這個也不會顯示 因為更多意義(發生時用ICMP ping去檢查)
* Scheduled Outages:如果這設備不想維護不想被opennms看到或不想被提醒, 就用這個
* Data Collection: SNMP/HTTP/NSClinet/JMX Collector, Thresholding
* Events:是openNMS的通訊bus, 內部創造而在守護程序間通知, 並且可由外部注入來做出反應
* Alarms:多個event導致一個alarm
    * 將event降並為一個Alarm is keyed by任何event參數
* Notification: 主要告知有興趣事件的方式, 有各種通知方式:email/SNMP/XMPP
* Discovery: opennms找node(裝置有著network address)的方式 
    * 自動尋找: discovery的守護程序發送ICMP ping來看那位址有無回應, 有的話"new suspect"event被產生後傳進event system. 守護程序查看event然後搜尋這IP有什麼可用服務, node跟服務被加進資料庫
    * 手動增加:經由網頁 輸入ip, 或send-event.pl
        * 可寫客制化Script
    * 半自動:對有發送給openNMS SNMP trap的任何未知的node, opennms會產生 newsuspect event,意思是你可以設置SNMP代理人來對opennms的社區傳送traps,重啟然後opennms會去探索這個node並排一個服務查找
* 堅持監控與node儲存於postgreSQL
* 時間序列儲存有3種 預設為JRobin(Demo, opennms用rrd tool)
    * JRobin(Java base): 不同平台, 中小量
        * 由RRDTool克隆, 不完整, 存在本地端
    * RRDTool(Java Interface):最大兼容性 中小資料量
        * 存本地端
        * 存時間序列資料(不是存在postgreSQL)
        * 由NMS 定期存取: ICMP, SNMP那些
    * Newts:可擴產性, 中量資料
        * 存在專用的assandra cluster給予擴展性並且可以儲存大規模
* $OPENNMS_HOME: /opt/opennms
* Service Monitor framework: 這主要元件被pollered並提供以下功能
    * 專宗被管理的來源
    * 測量反應時間質量
    * node的關聯以及接口停運based on [Critical Service](https://docs.opennms.org/opennms/releases/latest/guide-admin/guide-admin.html#ga-service-assurance-critical-service)
        * 使用ICMP做critical service
        * 如果critical服務掛了 其他所有服務也被視為掛了
        * 1.所有危急服務都UP只有http掛- 只有nodeLostService被傳誦
        * 2.其中一個Ip interface掛了, interfaceDown被傳誦, 那個Ip interface的其他服務不測試 被當成是unreachable.
        * 3.這個node所有危急服務掛了, 換成IP interface直接不管, 傳送nodeDown
* 當發現outage, Pollerd傳送event來建立Alarm, 也可以建立Notifications
    * ![](https://i.imgur.com/Wz0oooz.png)
    * Events由Poolerd產生(PDF:eventname/ description)
* Response Time Monitoring
    * Polling Packages可以於不同時間間隔去做polling來配置相似服務
        * 每個Packages包含一RRD定義
    * 所有反應時間測量are persisted in RRD files
    * 有很多種RTM
* icmpMonitor
    * 藉由傳送echo要求ICMP訊息來監控測試ICMP服務.有回傳就OK
    * 用來接受response time data並存成RRDtool file in Demo System
* HostResourceSwRunMonito
    * 監測一個或多個處理器, 經由SNMP檢查HOST-RESOURCES-MIB的hrSwRunTable, 確定是否正常: 比對hrSwRunName與hrSwRunState
        * 以上東西系統必須要支援
* SnmpMonitor
    * 由SNMP agents監控
    * 測試特定OID的回傳值(scalar object identifier)
    * 測試在整個資料表中的多個值
* Perfomance Management(Perfomance Data Collection)
    * 由Collectd daemon完成
    * 取得效能資料的管理agents跟協議是由collector做成
        * collector平行地運行於global執行緒池
* SnmpCollector
    * 經由SNMP協議蒐集效能資料
    * 在網頁使用者介面, 經由SNMP設置來取得SNMP Agent
    * 蒐集response time data然後儲存成RRDtool files in /var/opennms/rrd/snmp
* Event
    * 每個event有一個fixed fileds的數字以及0+個參數
    * 必要的filed
        * UEI: Universal Event Identifier
            * 獨特, 辨認event類型
            * 格式為URI
        * Event Label
            * 簡短總結這個event中每個例子的要旨
        * Description 長的, 每個例子
        * Log Message
            * 整體event, optionaling 
        * Severity 危急等級範圍
        * Event ID:數字, 特定event可以去查看
    * 其他可被重視的
        * Operator Instrction
            * 一組給opeator的指令來適當地回應這種類型的event
        * Alarm Data
            * 如果有這field, opennms會建立, 更新, 清除這個alarm, 根據特定alar-data
* Event的源頭:Opennms本身或外部
    * 內部:監控時與管理功能
    * 外部:SNMP Traps
* Alarms
    * Opennms用Managed entites(ME)監控所有服務, 網路有問題的狀態
    * event在被創造成alarms之前, 被當成interprocess communication meassages, 還有指出網路中的問題
        * 以前的opennms使用2個alarm:Down and Up alarm, org.opennms.alarmd.legacyAlarmState = true
        * Demo S:使用alarms而不是events
* Notification
    * 用來確保使用者發現event
    * email, paging, Slack, Twitter
* 取得效能資料
    * 創建了一個measurement Datasource可以[query Measurements API](http://docs.opennms.org/opennms/releases/23.0.4/guide-development/guide-development.html#_measurements_api)然後回傳資料
        * 在不是opennms上使用時, 需要report一個HTTP connection給measurements API
    * receive 
        * ![](https://i.imgur.com/lupBeew.png)
    * Measure API取得存在newts/rrd的collected value
    * GETs (reading data:單一屬性)
        * /measurements/{resourceID}/{attribute}
        * parameters: start, end, step(time interval), maxrows, aggregation(Average), fallbal-attribute(如果不存在第一個屬性的第二個屬性)
        * with curl
            * PDF
    * POSTs (readming data單或多屬性,多來源)
        * 讀json
* SNMP MIBs
    * 藉由SNMP取得資料
    * Name / Object ID / Descripion / Remarks
    * Host Resources MIB: RFC 2790
* [Juniper網路公司MIB](https://www.juniper.net/documentation/en_US/junos/topics/task/verification/cpu-utilization-using-mib.html)
    * jnxMIBs分支包含最主要的分支jnxBoxAnatomy包含部分:jnxOperatingTable
        * 在jnxOperatingTable還有jnxOperatingEntry下,可以使用jnxOperatingCPU物件來監控CPU
        * CPU / 記憶體使用量是特定值對上總量



## Opennms-> Navicat
>   Detect Outage →Send Event →Create Alarm (and Grenerate Notification



## ODBC JDBC

standard to access remote DB

Open Database Connectivity
Applicati

在ODBC誕生之前，如果要開發資料庫應用程式，則必須要使用資料庫廠商隨資料庫產品一同發布的一些工具集來存取資料庫，或者在程式中使用嵌入式SQL來存取資料庫。當時，對於存取資料庫的方法，缺乏一個基於C語言的統一編程介面。

Java Data Base Connectivity, java數據庫連接
用於執行SQL語法的Java API
由java語言編寫的接口為多種關聯資料庫統一訪問

JDBC驅動程式 分4種

從ODBC向JDBC過度
Java可以使用ODBC, 最好以JDBC_ODBC橋的形式使用
(其中1種驅動程式)

2.本地API驅動 用戶端載入資料庫廠商的本地程式碼庫來存取

3.網路協定驅動 給用戶端提供網路API, 用戶端JDBC使用Socket呼叫Server上的中介軟體

4.本地協定驅動 使用Socket, 直接通訊, 最快 最直接存翠的Java實現


Class.forName()載入Driver至DriverManager
JDBC URL輸入帳號密碼來連線
Connection conn=DriverMananger.getConnection();
Statement stmt = conn.createStatement()
Result rs = stmt.executeUpdate("SQL...")


1. Get a connection to database
2. Create a statement
3. Execute SQL query
4. Process the result set
> 用迴圈 .next()去跑


### How does JDBC work?
JDBC API is implemented through the JDBC driver.
JDBC driver: a set of classes that implement JDBC interfaces to process JDBC calls and return result sets to a JAVA application.

* DataSource object
* Connection object
* Statement, preparedStatement and CallableStatement objects
* ResultSet object

---

## NMS主機 - Putty
* putty 登入file system
    * rrdTool時間序列資料放在var/opennms/rrd
        * icmp:回應時間 - IP address 以資料夾分開
            * 資料內容: 裡面的資料取決於poller: icmp ping / ssh / http / etc
                * ds.properties: 定義哪些資料被蒐集
                * .meta file: 可以存多種形態的資料
                * .rrd: rrdTool file - 格式:binary
        * MiBs:由SNMP蒐集到的資料 - 以裝置node ID為資料夾 
            * 裡面還有子資料夾 取決於要蒐集怎樣的資料
                * 命名: ifDescr-MacAddress
                    * ifDescr 接口类型的描述 為了分開同個接口
                    * ==In OpenNMS DB, these are “snmpifdescr” and ‘snmpphysaddr” in “snmpinterface”table.-Check Out! : There are same MAC addresses. (As far as I know, MAC address should be unique.)==
                * node等級(ifType=ignore)的rrd資料就放在node資料夾中
                * 接口等級的資料放在進一步的資料夾中(為了特定接口分資料夾)
                    * 為了resource instance identifier跟 reosource type-namme
            * 資料內容 跟icmp一樣
                * string.property 在端口資料夾中 node資料夾沒看到
                * meta file裡面有snmp的mib object name
                * .txt是測試用: rrdTool dump出來
* 去讀rrd file
    * dump: 轉成ASCII, fetch: 取得一定時間內的rrd
    * 轉xml 上面是格式 下面是每個一段時間蒐集到的值
        * rrdtool dump diskIOLA5.rrd /tmp/diskIOLA5.xml
    * 取得30分鐘前的平均資料
        * rrdtool fetch diskIOLA5.rrd AVERAGE --start -30m
    * rrdtool last diskIOLA5.rrd
    * last, info, lastupdate:也回傳最常更新


## Others

* rrd 存放序列資料
* 有關網路
    * ICMP Internet Control Message Protocol
        * 用於網際網路協定IP internet protocol (套組織一) 傳送控制訊息
        * 通常返回錯誤訊息或分析路由, 錯誤資訊包含源資料
    * simple network management protocol
        * 由SNMP管理的網路之中3個元件: * 由SNMP管理的網路之中3個元件:
        * 管理端: network management system
        * managed device
        * 安裝在被管理的裝置, 監控回傳設備資訊: agent
            * 以變數呈現資訊 識別碼:object Identifier, OID
                * 1.3.6.1.4.1.9代表cisco
                * ![](https://i.imgur.com/KP4h09p.png)
        * 管理者發送request 代理者發送response
    * The MIB (Management Information Base) is used to collect the data through SNMP
        * [MIB的常用OID與說明](http://longfamily.pixnet.net/blog/post/84878036-%E7%B3%BB%E7%B5%B1%E7%9B%A3%E6%8E%A7%E5%B8%B8%E7%94%A8%E5%88%B0%E7%9A%84snmp-oid)
        * [如何寫MIB](https://www.tonylin.idv.tw/dokuwiki/doku.php/snmp:snmp:mibhelloworld)
        * 對於一個3th-party的SNMP oid，有MIB可以幫助你去了解它所提供的資訊是什麼，且可以對它做什麼操作
    * User Datagram Protocol- UDP 用戶資料包協定 / 用戶資料报協定
    * Open System Interconnection Reference Model OSI - 開放式系統互連通訊參考模型
    * Simple Mail Transfer Protocol，縮寫SMTP 簡單郵件傳輸協定
* var variable與系統運作過程有關 可變動的(又分可不可分享的) 
* RRDtool round-robin tool 
    * 處理序列資料 / RRD來儲存通過SNMP蒐集到的資料
    * 有一個獨立且完整的Java實施稱為rrd4j
    * 強大繪圖引擎 / 循環會重用 數據不會過大 不需要維護
    * round robin 一種儲存資料方式 以固定大小空間來儲存, 並有指標指向最新資料

* ssh
  * Secure Shell 安全外殼協議
  * 一種加密的網路傳輸協定
* http: hyperText Transfer Protocol 應用層協定
* IDC（Internet Data Center）
    * RS-232
        * 序列資料通訊的埠標準
    * EIA-485(RS485)
* Total Integration Manager (TIM)
    * 資料庫整合
    * 排程與來源端連結, 確保可靠.穩定
    * 連結資料儲存在整合DB與應用服務(RENOBIT)
    * 資料擷取:TIM代理程式 -> 排程連結頻率 -> 資料處理(大小/臨界值/統計) -> 仔入

* interface
    * Network Management System (NMS)
    * Application performance management (APM)
    * database management system (DBMS)
    * Real Time Streaming Protocol，RTSP


## WeMB Solutions
SMD部門 Surface Mounted Devices
> Surface Mount Technology 的一種

* IDC（Internet Data Center）
    * RS-232
        * 序列資料通訊的埠標準
    * EIA-485(RS485)
* Total Integration Manager (TIM) 
* bacnet
* renobit 管理資料中心
* interface
    * Network Management System (NMS)
    * Application performance management (APM)
    * database management system (DBMS)
    * Real Time Streaming Protocol，RTSP


## Water leak detector

各種sensor, PLC設置去poll, FMS接收

openNMS看不到fms溫溼度是正常的 兩邊是分開來的 只是要去看fms有沒有掛掉
 
## FMS
 
### 觀測設施
* 數位
    * 漏水感測
    * 空調
    * UPS不斷電系統
        * SMR Switch Mode Rectifier
        * LVDS Low-Voltage Differential Signaling
    * 煙霧偵測
    * 門開關
* RS-485
    * 溫溼度感應

### FMS資料庫
* 資料表
    * BwAnalogTable 溫溼度資料 14 sensor
        * 使用平均值, 間隔:1分鐘
        * Filed Name, Description, etc
            * TagName 感測器名稱(與TagName清單有關)
                * unique name來辨識sensor
                * 這些名字需要轉移map到demo System
                * TagName可以被當成key來蒐集並處理資料
                * 展示名稱必須更有說明性
                * TagNmae跟DisplayName之間的轉移應該由Demo System的integrated資料庫來完成
            * LogData 登入日期
            * LogTime 登入時間
            * AvgValue 平均值
        * PLC 每0.5輪詢一次, FMS每1分鐘蒐集一次
        * 使用平均值, 平均值有小數位, 所以必須在由TIM存進integrated資料庫前處理好
            * 61.648333>61.6, 24> 24 ?
        * 用來產生alarm
            * TIM額外處理來產生並儲存告警
            * 高溫/高低濕度
    * BwDiscreteTable
        * 被FMS管理的設備的登入資訊
        * TagName 告警名稱
            * 與TagName file清單有關
            * TagName必須由Demo System的integrated資料庫mapped到設備的名稱
            * TagName可被當成key來蒐集處理資料
            * 告警名稱必須有描述性
            * 單個或多個告警與特定設備有關並且這些告警被當成一個群組來管理
                * 資料庫價格儲存有設備ID filed告警資料來組成群組
            * 資料表被轉移在display/TagName之間由Demo System的資料庫完成
        * LogData 登入日期
        * LogTime 登入時間
        * LogValue 告警的狀態
            * 與TagName filed清單有關
                * TagName/Description/LogValue/Related Facilityd


---

* Liquibase
    * http://www.liquibase.org/
    * Liquibase是資料庫版本管理工具，設定的概念是把資料庫schema的異動(table的建立，column的異動，index的異動…)及資料內容的異動(insert，update，delete)用Liquibase定義的語法寫成xml格式
* By default OpenNMS Horizon uses ICMP as the critical service
* Check Out! : There are same MAC addresses. (As far as I know, MAC address should be unique.)
    * 是不是這樣也要解決的問題(主要在snmpinterface的snmpphysaddr 還有資料夾內有不同端口 但是相同address的)
* navicat
    * 圖形化資料庫管理及發展軟體
RRDtool round-robin tool
    * https://www.itsfun.com.tw/rrdtool/wiki-3901508-8996777
    * http://www.361way.com/rrdtool/4581.html
    * http://cmkxwack.pixnet.net/blog/post/109801533-%E5%B0%8Drrdtool%E7%9A%84%E7%B8%BD%E7%B5%90%EF%BC%88%E4%B8%80%EF%BC%89
    * 處理序列資料
    * 有一個獨立且完整的Java實施稱為rrd4j
    * 強大繪圖引擎
    * round robin 一種儲存資料方式 以固定大小空間來儲存, 並有指標指向最新資料
   * RRD來儲存通過SNMP蒐集到的資料
    * 循環會重用 數據不會過大 不需要維護
* var variable與系統運作過程有關 可變動的(又分可不可分享的)
    * http://linux.vbird.org/linux_basic/0210filepermission.php
* 搞懂ICMP
    * internet control message protocal
    * 用於網際網路協定IP internet protocol (套組織一) 傳送控制訊息
    * 通常返回錯誤訊息或分析路由, 錯誤資訊包含源資料
* 搞懂SNMP
    * simple network management protocol 由IETF定義 internet enginering task force
    * 由SNMP管理的網路之中3個元件:
        * 管理端: network management system
        * managed device
        * 安裝在被管理的裝置, 監控回傳設備資訊: agent
            * 以變數呈現資訊 識別碼:object Identifier, OID
                * 1.3.6.1.4.1.9代表cisco
                * ![](https://i.imgur.com/KP4h09p.png)
    * 管理者發送request 代理者發送response
* 用戶資料包協定（英語：User Datagram Protocol，縮寫：UDP，又稱用戶資料报協定
* 開放式系統互連通訊參考模型（英語：Open System Interconnection Reference Model，縮寫為OSI），簡稱為OSI模型（OSI model）
* MIBs
    * [MIBS](https://www.tonylin.idv.tw/dokuwiki/doku.php/snmp:snmp:mibhelloworld)
    * Management information base
    * 對於一個3th-party的SNMP oid，有MIB可以幫助你去了解它所提供的資訊是什麼，且可以對它做什麼操作

> server溫度 CPU使用率 接受到訊息 等等的
sensor接收到之後 經過ICMP 再到SNMP 還是2個都有 分別傳送
應該是兩種不同傳送方式
imcp是response time 資料夾是IP address
SNMP則是 node id
接著收到的資料經過rrd tool做成rrd file
rrd file做成postgresql, postgresql可由navicat 監控
postgresql又能從opennms顯示自己想看的東西
文件有講到 有SNMP搜集器 然後利用RRDtool
現在問題是 opennms是不是由postgresql產生的 還是直接rrd裡面的東西
應該是opennms去產生postgresql?
opennms有MIBS 去找RRD的東西 解析出來可以去產生資料庫

* [source 1](https://www.youtube.com/watch?v=7qRrTM1Wv-0)
* [source 2](http://www.syscom.com.tw/ePaper_Content_EPArticledetail.aspx?id=280&EPID=180&j=3&HeaderName=%E7%A0%94%E7%99%BC%E6%96%B0%E8%A6%96%E7%95%8C)
* [source 3](http://www.shunze.info/forum/thread.php?threadid=1934&boardid=34&styleid=1&sid=8b65dca8a2cdddc2c90b9ec878f79a2c)
* [source 4](https://www.cnblogs.com/JetpropelledSnake/p/9843131.html)

report-KSC

去info-node-選一個-resources graph