IF OBJECT_ID('SPS_EJECUTAR_CONSULTA','P') IS NOT NULL DROP PROCEDURE SPS_EJECUTAR_CONSULTA
GO
CREATE PROCEDURE DBO.SPS_EJECUTAR_CONSULTA
(
	@ReporteID			BIGINT			--Identificador del Reporte
	,@FilasPorPagina	BIGINT	= -1	--Tama�o p�gina
	,@NroPagina			INT	= 1			--N�mero de p�gina
	,@TotalPaginas		INT = 0 OUTPUT	--Retorno de cantidad de p�ginas
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	SELECT @SQLString = QUERY FROM REP WHERE REPORTEID=@ReporteID
	SELECT @SQLString = dbo.FNS_QUERY_REP(@ReporteID)
	IF @FilasPorPagina>0
	BEGIN
		EXEC dbo.SPS_PAGINAR @SQLString = @SQLString, @PageSize = @FilasPorPagina, @PageNumber = @NroPagina, @PageCount = @TotalPaginas OUTPUT
	END
	ELSE
	BEGIN
		EXECUTE sp_executesql @SQLString
	END
END
GO
DECLARE @PAGINAS AS INT
EXEC DBO.SPS_EJECUTAR_CONSULTA @ReporteID='1',@FilasPorPagina=1000, @TotalPaginas=@PAGINAS OUTPUT
SELECT @PAGINAS



--SELECT * FROM REPU WHERE 1=1 AND SEDEID = 'PPAL' AND USUARIOID = 'EZERPA' AND REPORTEID = 'CF45685A-6697-447A-B1EA-F10BA955B4079SAS' 

