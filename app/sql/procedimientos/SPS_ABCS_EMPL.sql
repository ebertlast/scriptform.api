IF OBJECT_ID('SPS_ABCS_EMPL','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_EMPL
GO
CREATE PROCEDURE DBO.SPS_ABCS_EMPL
(
	@ACCION			        VARCHAR(1) = 'S',
	@TipoID                 VARCHAR(2) = NULL,
	@NumeroIdentificacion   VARCHAR(16) = NULL,
	@RazonSocial            VARCHAR(500) = NULL,
	@DireccionFiscal        VARCHAR(500) = NULL,
    @Email                  VARCHAR(150) = NULL,
	@Telefono               VARCHAR(10) = NULL,
    @MunicipioID            VARCHAR(10) = NULL,
    @UsuarioID              VARCHAR(100) = NULL,
    @SedeID                 VARCHAR(100) = NULL,
    @NaturalezaID           VARCHAR(2) = NULL,
    @RegimeEmpresaID        VARCHAR(2) = NULL,
    @TamanoID               VARCHAR(2) = NULL,
    @TipoEmpresaID          VARCHAR(2) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO EMPL([TipoID]
      ,[NumeroIdentificacion]
      ,[RazonSocial]
      ,[DireccionFiscal]
      ,[Email]
      ,[Telefono]
      ,[MunicipioID]
      ,[UsuarioID]
      ,[SedeID]
      ,[NaturalezaID]
      ,[RegimeEmpresaID]
      ,[TamanoID]
      ,[TipoEmpresaID]
      )
      SELECT @TipoID,
            @NumeroIdentificacion,
            @RazonSocial,
            @DireccionFiscal,
            @Email,
            @Telefono,
            @MunicipioID,
            @UsuarioID,
            @SedeID,
            @NaturalezaID,
            @RegimeEmpresaID,
            @TamanoID,
            @TipoEmpresaID
        WHERE NOT EXISTS(SELECT * FROM EMPL WHERE TipoID=@TipoID AND NumeroIdentificacion=@NumeroIdentificacion)
	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM EMPL WHERE TipoID = @TipoID AND NumeroIdentificacion = @NumeroIdentificacion 
		-- AND EMPRESAID NOT IN (SELECT DISTINCT EMPRESAID FROM SED)
	END
	IF @ACCION = 'C'
	BEGIN
		UPDATE [dbo].[EMPL]
        SET [RazonSocial] = @RazonSocial
            ,[DireccionFiscal] = @DireccionFiscal
            ,[Email] = @Email
            ,[Telefono] = @Telefono
            ,[MunicipioID] = @MunicipioID
            -- ,[UsuarioID] = @UsuarioID
            ,[SedeID] = @SedeID
            ,[NaturalezaID] = @NaturalezaID
            ,[RegimeEmpresaID] = @RegimeEmpresaID
            ,[TamanoID] = @TamanoID
            ,[TipoEmpresaID] = @TipoEmpresaID
        WHERE   TipoID = @TipoID 
        AND     NumeroIdentificacion = @NumeroIdentificacion 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [TipoID]
            ,[NumeroIdentificacion]
            ,[RazonSocial]
            ,[DireccionFiscal]
            ,[Email]
            ,[Telefono]
            ,[MunicipioID]
            ,[UsuarioID]
            ,[SedeID]
            ,[NaturalezaID]
            ,[RegimeEmpresaID]
            ,[TamanoID]
            ,[TipoEmpresaID]
            ,[FechaRegistro]
        FROM [dbo].[EMPL]
        WHERE 1=1
        AND [TipoID] = CASE WHEN @TipoID IS NULL THEN [TipoID] ELSE @TipoID END
        AND [NumeroIdentificacion] = CASE WHEN @NumeroIdentificacion IS NULL THEN [NumeroIdentificacion] ELSE @NumeroIdentificacion END
        AND [RazonSocial] = CASE WHEN @RazonSocial IS NULL THEN [RazonSocial] ELSE @RazonSocial END
        AND [DireccionFiscal] = CASE WHEN @DireccionFiscal IS NULL THEN [DireccionFiscal] ELSE @DireccionFiscal END
        AND [Email] = CASE WHEN @Email IS NULL THEN [Email] ELSE @Email END
        AND [Telefono] = CASE WHEN @Telefono IS NULL THEN [Telefono] ELSE @Telefono END
        AND [MunicipioID] = CASE WHEN @MunicipioID IS NULL THEN [MunicipioID] ELSE @MunicipioID END
        AND [UsuarioID] = CASE WHEN @UsuarioID IS NULL THEN [UsuarioID] ELSE @UsuarioID END
        AND [SedeID] = CASE WHEN @SedeID IS NULL THEN [SedeID] ELSE @SedeID END
        AND [NaturalezaID] = CASE WHEN @NaturalezaID IS NULL THEN [NaturalezaID] ELSE @NaturalezaID END
        AND [RegimeEmpresaID] = CASE WHEN @RegimeEmpresaID IS NULL THEN [RegimeEmpresaID] ELSE @RegimeEmpresaID END
        AND [TamanoID] = CASE WHEN @TamanoID IS NULL THEN [TamanoID] ELSE @TamanoID END
        AND [TipoEmpresaID] = CASE WHEN @TipoEmpresaID IS NULL THEN [TipoEmpresaID] ELSE @TipoEmpresaID END

	END
END
GO
EXEC SPS_ABCS_EMPL --@TipoID='CC'