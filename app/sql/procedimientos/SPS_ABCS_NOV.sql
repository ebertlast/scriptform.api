IF OBJECT_ID('SPS_ABCS_NOV','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_NOV
GO
CREATE PROCEDURE DBO.SPS_ABCS_NOV
(
	@ACCION     		VARCHAR(1) = 'S',
	@NovedadID 			VARCHAR(9) = NULL,
	@DescripcionNovedad VARCHAR(100) = NULL,
	@Afiliacion 		BIT = NULL,
	@NovedadContrato 	BIT = NULL,
	@NovedadGenerales 	BIT = NULL,
	@NovedadEmpleador 	BIT = NULL,
	@NovedadEstado 		BIT = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
		INSERT INTO [dbo].[NOV]
           ([NovedadID]
           ,[DescripcionNovedad]
           ,[Afiliacion]
           ,[NovedadContrato]
           ,[NovedadGenerales]
           ,[NovedadEmpleador]
           ,[NovedadEstado])
     	VALUES
           (@NovedadID
           ,@DescripcionNovedad
           ,@Afiliacion
           ,@NovedadContrato
           ,@NovedadGenerales
           ,@NovedadEmpleador
           ,@NovedadEstado)
	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[NOV]
		WHERE [NovedadID] = @NovedadID
	END
	IF @ACCION = 'C'
	BEGIN
		UPDATE [dbo].[NOV]
		SET  [DescripcionNovedad] = CASE WHEN @DescripcionNovedad IS NULL THEN DescripcionNovedad ELSE @DescripcionNovedad END
			,[Afiliacion] = CASE WHEN @Afiliacion IS NULL THEN Afiliacion ELSE @Afiliacion END
			,[NovedadContrato] = CASE WHEN @NovedadContrato IS NULL THEN NovedadContrato ELSE @NovedadContrato END
			,[NovedadGenerales] = CASE WHEN @NovedadGenerales IS NULL THEN NovedadGenerales ELSE @NovedadGenerales END
			,[NovedadEmpleador] = CASE WHEN @NovedadEmpleador IS NULL THEN NovedadEmpleador ELSE @NovedadEmpleador END
			,[NovedadEstado] = CASE WHEN @NovedadEstado IS NULL THEN NovedadEstado ELSE @NovedadEstado END
		WHERE [NovedadID] = @NovedadID
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT * FROM NOV
        WHERE NovedadID = CASE WHEN ISNULL(@NOVEDADID,'')='' THEN NovedadID ELSE @NOVEDADID END
		AND DescripcionNovedad = CASE WHEN @DescripcionNovedad IS NULL THEN DescripcionNovedad ELSE @DescripcionNovedad END
		AND Afiliacion = CASE WHEN @Afiliacion IS NULL THEN Afiliacion ELSE @Afiliacion END
		AND NovedadContrato = CASE WHEN @NovedadContrato IS NULL THEN NovedadContrato ELSE @NovedadContrato END
		AND NovedadGenerales = CASE WHEN @NovedadGenerales IS NULL THEN NovedadGenerales ELSE @NovedadGenerales END
		AND NovedadEmpleador = CASE WHEN @NovedadEmpleador IS NULL THEN NovedadEmpleador ELSE @NovedadEmpleador END
		AND NovedadEstado = CASE WHEN @NovedadEstado IS NULL THEN NovedadEstado ELSE @NovedadEstado END
        ORDER BY DescripcionNovedad
	END
END
GO
EXEC DBO.SPS_ABCS_NOV @NOVEDADID='999'




