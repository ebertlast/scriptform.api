IF OBJECT_ID (N'dbo.FNS_FECHA_SIN_HORA', N'FN') IS NOT NULL DROP FUNCTION dbo.FNS_FECHA_SIN_HORA;
GO
CREATE FUNCTION dbo.FNS_FECHA_SIN_HORA (@FECHA DATETIME)
RETURNS DATETIME
WITH EXECUTE AS CALLER
AS
BEGIN
	RETURN CAST(CONVERT(VARCHAR,@FECHA,103) AS DATETIME)
END;
GO
SELECT DBO.FNS_FECHA_SIN_HORA(GETDATE());