IF OBJECT_ID('SPS_ABCS_GDI','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_GDI
GO
CREATE PROCEDURE DBO.SPS_ABCS_GDI
(
	@ACCION                        VARCHAR(1) = 'S',
	@GradoDiscapacidadId           VARCHAR(2) = NULL,
    @DescripcionGradoDiscapacidad  VARCHAR(15) = NULL,
    @LargoGradoDiscapacidad        INT = NULL,
    @TipoDatoGradoDiscapacidad     VARCHAR(10) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[GDI]
           ([GradoDiscapacidadId]
           ,[DescripcionGradoDiscapacidad]
           ,[LargoGradoDiscapacidad]
           ,[TipoDatoGradoDiscapacidad])
        SELECT @GradoDiscapacidadId, @DescripcionGradoDiscapacidad, @LargoGradoDiscapacidad, @TipoDatoGradoDiscapacidad
        WHERE NOT EXISTS(SELECT * FROM [dbo].[GDI] WHERE GradoDiscapacidadId=@GradoDiscapacidadId )
        AND ISNULL(@GradoDiscapacidadId,'')<>'' AND ISNULL(@DescripcionGradoDiscapacidad,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[GDI] WHERE [dbo].[GDI].[GradoDiscapacidadId] = @GradoDiscapacidadId
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[GDI]
        SET 
            [DescripcionGradoDiscapacidad] = CASE WHEN ISNULL(@DescripcionGradoDiscapacidad,'')='' THEN [DescripcionGradoDiscapacidad] ELSE @DescripcionGradoDiscapacidad END
            ,[LargoGradoDiscapacidad] = CASE WHEN ISNULL(@LargoGradoDiscapacidad,-1)<0 THEN [LargoGradoDiscapacidad] ELSE @LargoGradoDiscapacidad END
            ,[TipoDatoGradoDiscapacidad] = CASE WHEN ISNULL(@TipoDatoGradoDiscapacidad,'')='' THEN [TipoDatoGradoDiscapacidad] ELSE @TipoDatoGradoDiscapacidad END
        WHERE [GradoDiscapacidadId] = @GradoDiscapacidadId 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [GradoDiscapacidadId]
            ,[DescripcionGradoDiscapacidad]
            ,[LargoGradoDiscapacidad]
            ,[TipoDatoGradoDiscapacidad]
        FROM [dbo].[GDI]
        WHERE   1=1
        AND     [GradoDiscapacidadId] = CASE WHEN ISNULL(@GradoDiscapacidadId ,'')='' THEN [GradoDiscapacidadId] ELSE @GradoDiscapacidadId END
        AND     [DescripcionGradoDiscapacidad] = CASE WHEN ISNULL(@DescripcionGradoDiscapacidad ,'')='' THEN [DescripcionGradoDiscapacidad] ELSE @DescripcionGradoDiscapacidad END
        AND     [TipoDatoGradoDiscapacidad] = CASE WHEN ISNULL(@TipoDatoGradoDiscapacidad,'')='' THEN [TipoDatoGradoDiscapacidad] ELSE @TipoDatoGradoDiscapacidad END
        AND     [LargoGradoDiscapacidad] = CASE WHEN ISNULL(@LargoGradoDiscapacidad,-1)<0 THEN [LargoGradoDiscapacidad] ELSE @LargoGradoDiscapacidad END
        ORDER BY [DescripcionGradoDiscapacidad]
	END
END
GO
EXEC SPS_ABCS_GDI 




