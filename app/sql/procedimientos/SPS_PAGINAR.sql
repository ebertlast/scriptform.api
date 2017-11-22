IF OBJECT_ID('SPS_PAGINAR','P') IS NOT NULL DROP PROCEDURE SPS_PAGINAR
GO
CREATE PROCEDURE SPS_PAGINAR
	@SQLString NVARCHAR(MAX)	  --Consulta SQL
	,@PageSize INT			      --Tamaño página
	,@PageNumber INT		      --Número de página
	,@PageCount INT OUT		      --Retorno de cantidad de páginas
AS
DECLARE @TablaTemp NVARCHAR(10) = RIGHT(REPLACE(NEWID(),'-',''),10)
DECLARE @OPENQUERY nvarchar(4000)
DECLARE @TSQL nvarchar(4000)
DECLARE @LinkedServer nvarchar(4000) = @@servername
DECLARE @ParmDefinition nvarchar(500);  

BEGIN
	SET NOCOUNT ON;
	--SET @SQLString=REPLACE(@SQLString,'''','''''')
	SET @LinkedServer = @@servername
	SET @OPENQUERY = 'SELECT TOP 0 * into ##'+@TablaTemp+' FROM OPENQUERY(['+ @LinkedServer + '],'''
	SET @TSQL = REPLACE(@SQLString,'''','''''') +''')' 
	--PRINT @OPENQUERY+@TSQL

	EXEC (@OPENQUERY+@TSQL) 
	EXEC ('ALTER TABLE ##'+@TablaTemp+' ADD TempIdentity BIGINT IDENTITY(1,1)') 
	--SET @OPENQUERY = 'INSERT INTO ##'+@TablaTemp+' SELECT * FROM OPENQUERY(['+ @LinkedServer + '],'''
	--SET @TSQL = 'EXEC [ScriptForms].[dbo].[SPS_ABCS_AFI]'')' 
	--EXEC (@OPENQUERY+@TSQL) 

	--PRINT 'INSERT INTO ##'+@TablaTemp+' WITH (TABLOCK) '+@SQLString
	EXEC('INSERT INTO ##'+@TablaTemp+' WITH (TABLOCK) '+@SQLString)
	

	--Validación de precondiciones
	SET @PageCount = 0
	IF @PageSize < 1  OR @PageNumber < 1 RETURN

	--Ajuste de cantidad de páginas
	DECLARE @RecordCnt INT = 0
	--SELECT @RecordCnt = COUNT(*) FROM AFI
	SET @SQLString=N'SELECT @RecordCnt = COUNT(*) FROM ##'+@TablaTemp
	SET @ParmDefinition = N'@RecordCnt INT OUTPUT'; 
	EXEC sp_executesql @SQLString, @ParmDefinition, @RecordCnt=@RecordCnt OUTPUT

	IF @RecordCnt = 0
		SET @PageCount = 0
	ELSE IF @RecordCnt % @PageSize = 0
		SET @PageCount = @RecordCnt / @PageSize
	ELSE
		SET @PageCount = (@RecordCnt / @PageSize) + 1 
                        
	--Registros paginados,filtrados y ordenados
	DECLARE @offset INT =  (@PageSize * (@PageNumber - 1))
	 
	--SELECT  * FROM #TEMP ORDER BY TempIdentity OFFSET @offset ROWS FETCH NEXT @PageSize ROWS ONLY; 
	
	--DECLARE @SQLString nvarchar(500);  
	SET @SQLString=N'SELECT * FROM ##'+@TablaTemp+' ORDER BY TempIdentity OFFSET @A ROWS FETCH NEXT @B ROWS ONLY; '
	SET @ParmDefinition = N'@A INT, @B INT';  
	EXECUTE sp_executesql @SQLString, @ParmDefinition, @A = @offset, @B = @PageSize;  

	EXEC('DROP TABLE ##'+@TablaTemp+'')

END
GO

DECLARE @PageCount int
EXEC	SPS_PAGINAR
	@SQLString = 'SELECT top 1000 * FROM ScriptForms.dbo.AFI',
	--@SQLString = 'EXEC [ScriptForms].[dbo].[SPS_ABCS_AFI]',
	@PageSize = 10,
	@PageNumber = 100,
	@PageCount = @PageCount OUTPUT

PRINT 'PÁGINA 1 DE '+CAST(@PageCount AS VARCHAR)
SELECT	@PageCount as N'@PageCount'


