-- Naturaleza de una empresa
IF OBJECT_ID('SPS_ABCS_NAE','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_NAE
GO
CREATE PROCEDURE DBO.SPS_ABCS_NAE
(
	@ACCION             VARCHAR(1) = 'S',
	@NaturalezaID           VARCHAR(2) = NULL,
    @DescripcionNaturaleza  VARCHAR(50) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[NAE]
           ([NaturalezaID]
           ,[DescripcionNaturaleza])
        SELECT @NaturalezaID, @DescripcionNaturaleza
        WHERE NOT EXISTS(SELECT * FROM [dbo].[NAE] WHERE NaturalezaID=@NaturalezaID )
        AND ISNULL(@NaturalezaID,'')<>'' AND ISNULL(@DescripcionNaturaleza,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[NAE] WHERE [dbo].[NAE].[NaturalezaID] = @NaturalezaID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[NAE]
        SET 
            [DescripcionNaturaleza] = CASE WHEN ISNULL(@DescripcionNaturaleza,'')='' THEN [DescripcionNaturaleza] ELSE @DescripcionNaturaleza END
        WHERE [NaturalezaID] = @NaturalezaID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [NaturalezaID]
            ,[DescripcionNaturaleza]
        FROM [dbo].[NAE]
        WHERE   1=1
        AND     [NaturalezaID] = CASE WHEN ISNULL(@NaturalezaID ,'')='' THEN [NaturalezaID] ELSE @NaturalezaID END
        AND     [DescripcionNaturaleza] = CASE WHEN ISNULL(@DescripcionNaturaleza ,'')='' THEN [DescripcionNaturaleza] ELSE @DescripcionNaturaleza END
        ORDER BY [DescripcionNaturaleza]
	END
END
GO
EXEC SPS_ABCS_NAE --@TABLA = 'GENERAL', @CAMPO = 'TIPONOVEDAD'




