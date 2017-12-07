IF OBJECT_ID('SPS_ABCS_NOV','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_NOV
GO
CREATE PROCEDURE DBO.SPS_ABCS_NOV
(
	@ACCION     VARCHAR(1) = 'S',
	@NOVEDADID  VARCHAR(9)=''
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
		SET @ACCION='S'
	END 
	IF @ACCION = 'B'
	BEGIN
		SET @ACCION='S'
	END
	IF @ACCION = 'C'
	BEGIN
		SET @ACCION='S'
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT * FROM NOV
        WHERE NovedadID = CASE WHEN ISNULL(@NOVEDADID,'')='' THEN NovedadID ELSE @NOVEDADID END
        ORDER BY DescripcionNovedad
	END
END
GO
EXEC DBO.SPS_ABCS_NOV @NOVEDADID='999'



