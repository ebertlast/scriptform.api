IF OBJECT_ID('SPS_REPORT_EXCEL','P') IS NOT NULL DROP PROCEDURE SPS_REPORT_EXCEL
GO
CREATE PROCEDURE SPS_REPORT_EXCEL
	@ReporteID BIGINT  
	--,@UrlFile VARCHAR(1000) OUT
AS
DECLARE @Directorio VARCHAR(1000)=DBO.FNS_VALORVARIABLE('URLDIREXPORT')--='C:\devAngular\'
DECLARE @NombreArchivo VARCHAR(1000)--='Prueba'
DECLARE @SQLString AS CHAR(8000) = dbo.FNS_QUERY_REP(@ReporteID)
DECLARE @UrlFile VARCHAR(1000) = ''
BEGIN
	
	SELECT @NombreArchivo= REPLACE(REPLACE(NOMBRE,'/',''),'\','') FROM REP WHERE REPORTEID=@ReporteID
	--SELECT @NombreArchivo=LTRIM(RTRIM(@NombreArchivo))+'_'+REPLACE(REPLACE(CONVERT(VARCHAR,GETDATE(),109),' ','_'),':','.')
	SELECT @NombreArchivo=LTRIM(RTRIM(@NombreArchivo))+'_'+REPLACE(CONVERT(VARCHAR,GETDATE(),102),'.','')+'_'+REPLACE(CONVERT(VARCHAR,GETDATE(),108),':','')
	--DECLARE @TitulosColumnas AS NVARCHAR(MAX) = ''
	--SELECT
	--	@TitulosColumnas =
	--    stuff((
	--        SELECT ',' + '[' + NAME+ ']'
	--        FROM sys.dm_exec_describe_first_result_set(@SQLString, NULL, 0)
	--        for xml path('')
	--    ),1,1,'') 
	--SET @SQLString = 'SELECT '+@TitulosColumnas+' UNION ALL ' + @SQLString
	--SELECT name,* FROM sys.dm_exec_describe_first_result_set('SELECT * FROM AFI', NULL, 0) ;
	--PRINT ltrim(rtrim(@SQLString))

	--SELECT @UrlFile=LTRIM(RTRIM(@Directorio))+LTRIM(RTRIM(@NombreArchivo))+'.xls'
	SELECT @UrlFile=LTRIM(RTRIM(@NombreArchivo))+'.xls'
	SELECT @UrlFile AS UrlFile
	SELECT @SQLString='bcp "'+LTRIM(RTRIM(@SQLString))+'" queryout '+@Directorio+@NombreArchivo+'.xls -o "'+@Directorio+@NombreArchivo+'.txt" -T -c -C RAW' 
	--SELECT @SQLString='bcp "'+LTRIM(RTRIM(@SQLString))+'" queryout '+@Directorio+@NombreArchivo+'.xls -T -c -C RAW' 
	EXEC master..xp_cmdshell @SQLString

END
GO

--EXEC SPS_REPORT_EXCEL @ReporteID=1