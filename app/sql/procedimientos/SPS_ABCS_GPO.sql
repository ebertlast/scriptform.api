IF OBJECT_ID('SPS_ABCS_GPO','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_GPO
GO
CREATE PROCEDURE DBO.SPS_ABCS_GPO
(
	@ACCION             VARCHAR(1) = 'S',
	@GrupoId           VARCHAR(2) = NULL,
    @DescripcionGrupo  VARCHAR(100) = NULL,
    @LargoGrupo        INT = NULL,
    @TipoDatoGrupo     VARCHAR(10) = NULL

    -- @GrupoId           VARCHAR(2) = NULL,
    -- @DescripcionGrupo  VARCHAR(15) = NULL,
    -- @LargoGrupo        INT = NULL,
    -- @TipoDatoGrupo     VARCHAR(10) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[GPO]
           ([GrupoId]
           ,[DescripcionGrupo]
           ,[LargoGrupo]
           ,[TipoDatoGrupo])
        SELECT @GrupoId, @DescripcionGrupo, @LargoGrupo, @TipoDatoGrupo
        WHERE NOT EXISTS(SELECT * FROM [dbo].[GPO] WHERE GrupoId=@GrupoId )
        AND ISNULL(@GrupoId,'')<>'' AND ISNULL(@DescripcionGrupo,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[GPO] WHERE [dbo].[GPO].[GrupoId] = @GrupoId
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[GPO]
        SET 
            [DescripcionGrupo] = CASE WHEN ISNULL(@DescripcionGrupo,'')='' THEN [DescripcionGrupo] ELSE @DescripcionGrupo END
            ,[LargoGrupo] = CASE WHEN ISNULL(@LargoGrupo,-1)<0 THEN [LargoGrupo] ELSE @LargoGrupo END
            ,[TipoDatoGrupo] = CASE WHEN ISNULL(@TipoDatoGrupo,'')='' THEN [TipoDatoGrupo] ELSE @TipoDatoGrupo END
        WHERE [GrupoId] = @GrupoId 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [GrupoId]
            ,[DescripcionGrupo]
            ,[LargoGrupo]
            ,[TipoDatoGrupo]
        FROM [dbo].[GPO]
        WHERE   1=1
        AND     [GrupoId] = CASE WHEN ISNULL(@GrupoId ,'')='' THEN [GrupoId] ELSE @GrupoId END
        AND     [DescripcionGrupo] = CASE WHEN ISNULL(@DescripcionGrupo ,'')='' THEN [DescripcionGrupo] ELSE @DescripcionGrupo END
        AND     [TipoDatoGrupo] = CASE WHEN ISNULL(@TipoDatoGrupo,'')='' THEN [TipoDatoGrupo] ELSE @TipoDatoGrupo END
        AND     [LargoGrupo] = CASE WHEN ISNULL(@LargoGrupo,-1)<0 THEN [LargoGrupo] ELSE @LargoGrupo END
        ORDER BY [DescripcionGrupo]
	END
END
GO
EXEC SPS_ABCS_GPO




