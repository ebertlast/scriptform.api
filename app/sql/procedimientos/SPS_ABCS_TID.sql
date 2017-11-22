IF OBJECT_ID('SPS_ABCS_TID','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_TID
GO
CREATE PROCEDURE DBO.SPS_ABCS_TID
(
	@ACCION				VARCHAR(1) = 'S',
	@TipoID				VARCHAR(2) = '',
	@DescripcionID		VARCHAR(50) = '',
	@LargoID			INT = 0,
	@TipoDatoID			VARCHAR(10) = 'string',
	@PersonaNatural		INT = 1,
	@PersonaJuridica	INT = 1
)
WITH ENCRYPTION
AS
DECLARE @SQLString AS nvarchar(MAX)
BEGIN
	IF @ACCION = 'A'
	BEGIN
		INSERT INTO TID(TipoID,DescripcionID,LargoID,TipoDatoID,PersonaNatural,PersonaJuridica)
		SELECT @TipoID,@DescripcionID,@LargoID,@TipoDatoID,@PersonaNatural,@PersonaJuridica
		WHERE NOT EXISTS(SELECT * FROM TID WHERE TipoID=@TipoID)
	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM TID 
		WHERE TipoID=@TipoID 
		AND TipoID NOT IN (SELECT DISTINCT TIPOID FROM AFI WITH(NOLOCK))
	END
	IF @ACCION = 'C'
	BEGIN
		UPDATE TID SET 
			--TipoID = CASE WHEN ISNULL(TipoID,'')='' THEN TipoID ELSE @TipoID END,
			DescripcionID = CASE WHEN ISNULL(@DescripcionID,'')='' THEN DescripcionID ELSE @DescripcionID END,
			LargoID = CASE WHEN ISNULL(@LargoID,-1)<0 THEN LargoID ELSE @LargoID END,
			TipoID = CASE WHEN ISNULL(@TipoID,'')='' THEN TipoID ELSE @TipoID END,
			PersonaNatural = CASE WHEN ISNULL(@PersonaNatural,-1)<0 OR ISNULL(@PersonaNatural,-1)>1  THEN PersonaNatural ELSE @PersonaNatural END,
			PersonaJuridica = CASE WHEN ISNULL(@PersonaJuridica,-1)<0 OR ISNULL(@PersonaJuridica,-1)>1 THEN PersonaJuridica ELSE @PersonaJuridica END
		WHERE TipoID=@TipoID
	END
	IF @ACCION = 'S'
	BEGIN
		SET @SQLString='SELECT * '
		SET @SQLString=@SQLString+'FROM TID '
		SET @SQLString=@SQLString+'WHERE 1=1 '
		IF ISNULL(@TipoId,'')<>'' SET @SQLString=@SQLString+'AND TipoId = '''+@TipoId+''' '
		IF ISNULL(@DescripcionID,'')<>'' SET @SQLString=@SQLString+'AND DescripcionID = '''+@DescripcionID+''' '
		SET @SQLString=@SQLString+'ORDER BY TipoID '
		--PRINT @SQLSTRING
		EXECUTE sp_executesql @SQLString
	END
END
GO
--EXEC DBO.SPS_ABCS_REPP @ACCION='A', @REPORTEID='1', @NOMBRE='@TipoId', @UTILIZAQUERY='PPAL'
EXEC DBO.SPS_ABCS_TID --@REPORTEID='1' --@USUARIOID='EZERPA', @SEDEID='PPAL'--@SEDEID='ppal'
