# NYH smart temp
 1. ภาพรวม
การทำงานของการเก็บข้อมูลจากเซนเซอร์อุณหภูมิความชื้น จะใช้บอร์ดไมโครคอนโทรลเลอร์ ESP8266 ซึ่งเขียนด้วยภาษา c++ บน Arduino IDE สำหรับเชื่อมต่อกับระบบไวไฟและส่งค่าข้อมูลขึ้นไปเก็บที่เว็บเซิร์ฟเวอร์ โดยการส่งข้อมูลจะส่งโดยใช้โปรโตคอล http post request ไปยังเว็บเซิร์ฟเวอร์ ทางด้านเว็บจะใช้ภาษา php สำหรับรับข้อมูลจากอุปกรณ์ ESP8266 และจะเก็บข้อมูลเป็น Time series ดาต้าเบสบน sqlite สำหรับแต่ละอุปกรณ์จะมีดาต้าเบสเป็นชื่อของ ESP ID
 2. อุปกรณ์เซนเซอร์
	 1. อุปกรณ์
		 1. บอร์ดไมโครคอนโทรลเลอร์ WEMOS D1 mini ใช้ชิป ESP8266
เป็นบอร์ดไมโครคอนโทรลเลอร์ที่เขียนด้วยภาษา C++ และทำงานบน Arduino IDE ที่สามารถเชื่อมต่อกับไวไฟได้ ทำให้สะดวกกับการส่งข้อมูลไร้สายได้
สำหรับบอร์ด ESP8266 จะมีสเปคดังนี้

![ESP8266 Specification](docs/Screenshot%202023-06-13%20125533.png)

![Wemos d1 mini](docs/wemos.png)		
		 2. เซนเซอร์อุณหภูมิตู้แช่ NTC ขนาด 10KΩ
NTC (Negative Temperature Coefficient) คือ เซ็นเซอร์วัดอุณหภูมิประเภทเทอร์มิสเตอร์ (Thermistor) เมื่ออุณหภูมิสูงขึ้น ค่าความต้านทาน (Resistance) จะลดลง (ค่าความต้านทานจะมีค่าเป็น กิโลโอห์ม (KΩ) เช่น 2KΩ, 10KΩ) โดยมีย่านการวัดอุณหภูมิ -30 ํC ถึง 130 ํC
หลักการทำงานของเซนเซอร์ NTCคือ เมื่ออุณหภูมิต่ำลง ความต้านทานจะเพิ่มขึ้น ซึ่งสามารถใช้งานในการวัดและตรวจจับอุณหภูมิได้ โดยนำ NTC มาต่อกับตัวต้านทานค่าคงที่ และต่อกับแหล่งจ่ายไฟ จะทำให้เป็นวงจรแบ่งแรงดัน(Voltage divider circuit) โดยเมื่อค่าความต้านทานของ NTC เปลี่ยนไป จะทำให้ค่าความต้านทานเปลี่ยนไปนั่นเอง
ในโปรเจคนี้จะใช้ NTC ขนาด10KΩ (ที่อุณหภูมิ 25 ํC จะมีความต้านทาน 10KΩ) มาต่ออนุกรมกับตัวต้านทานคงที่ขนาด 10KΩ แล้วนำไปต่อกับแหล่งจ่าย 3.3v จากบอร์ด wemos d1 mini และต่อจุดระหว่าง ntc และตัวต้านทาน10KΩ เข้าไปยังขา ADC ของบอร์ด เพื่อวัดแรงดันที่เปลี่ยนไป โดยคำนวณจากสมการแบ่งแรงดันไฟฟ้า ก็จะได้อุณภูมิขณะนั้นออกมาได้นั่นเอง
สรุปได้ว่าเซ็นเซอร์ NTC ถูกออกแบบมาเพื่อวัดอุณหภูมิ โดยใช้ค่าความต้านทานของเซนเซอร์ในการตรวจวัด และนำข้อมูลความต่างศักย์ที่ได้ไปแปลงเป็นค่าอุณหภูมิที่ถูกต้องตามมาตรฐานหรือสูตรที่กำหนดไว้ในระบบวัดอุณหภูมิ
		 3. เซนเซอร์อุณหภูมิความชื้นในอากาศ DHT22
DHT22 เป็นเซ็นเซอร์ที่ใช้ในการวัดอุณหภูมิและความชื้นในสภาพแวดล้อม โดยมีหลักการทำงานที่คล้ายคลึงกับเซ็นเซอร์ NTC แต่มีความสามารถในการวัดค่าความชื้นเพิ่มเติม
เซ็นเซอร์ DHT22 ประกอบด้วยองค์ประกอบสำคัญสองส่วน คือ เซ็นเซอร์อุณหภูมิ (Temperature Sensor) และเซ็นเซอร์ความชื้น (Humidity Sensor) ซึ่งองค์ประกอบทั้งสองนี้อยู่ในตัวเดียวกัน
ตัวเซนเซอร์จะสื่อสารกับบอร์ดไมโครคอนโทรลเลอร์ด้วย 1-wire communication โดยต่อเข้ากับขา D7 ของบอร์ด
		 4. จอแสดงผล OLED SSD1306
		 5. จอ tm1637
	 2. โค้ดและการทำงาน
 3. เว็บเซิร์ฟเวอร์สำหรับเก็บข้อมูล
	 1. โค้ดและการทำงาน
	 2. ติดตั้งบนเว็บโฮสติ้ง
